<?php

namespace Cat\Modules\Masivo\Services\Presentismos;

use Cat\Models\Base;
use Cat\Models\Turno;
use Cat\Modules\Agentes\Repositories\AgenteRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;

class Generator
{
    /** @var  Turno */
    protected $turno;

    /** @var  Base */
    protected $base;

    /** @var string */
    protected $newFileName;

    /** @var  string */
    protected $storageFolder;

    /** @var string */
    protected $storageKey;

    /** @var string */
    protected $templateFileName;

    /** @var string */
    protected $templateFolder;

    /** @var string */
    protected $copyDestination;

    /** @var string */
    protected $sheetName;

    public function __construct(Base $base, Turno $turno)
    {
        $this->base = $base;
        $this->turno = $turno;
        $this->newFileName = $this->generateName();
        $this->templateFolder = '/templates/';
        $this->copyDestination = 'presentismos/';
        $this->storageKey = 'masivo';
        $this->templateFileName = 'presentismos_masivo_template.xls';
        $this->storageFolder = Storage::disk($this->storageKey)->path('');
        $this->sheetName = 'presentismos_masivo';
    }


    public function execute()
    {
        $this->generateTemplateCopy();
        $this->moveTemplateCopy();

        $data = new class($this->getDataForTemplate()) implements FromCollection {
            public function __construct(private Collection $collection)
            {
            }

            public function collection(): Collection
            { return $this->collection; }
        };

        Excel::store($data, $this->getFullNewFileName());
    }

    public function getFullNewFileName()
    {
        return $this->storageFolder . $this->copyDestination . $this->newFileName;
    }

    public function getFileName()
    {
        return $this->newFileName;
    }

    private function generateTemplateCopy()
    {
        Storage::disk($this->storageKey)->delete($this->newFileName);
        Storage::disk($this->storageKey)
            ->copy($this->templateFolder . $this->templateFileName, $this->newFileName);
    }

    private function moveTemplateCopy()
    {
        Storage::disk($this->storageKey)
            ->delete($this->copyDestination . $this->newFileName);
        Storage::disk($this->storageKey)
            ->move($this->newFileName, $this->copyDestination . $this->newFileName);
    }

    private function generateName()
    {
        return 'template_base_' . str_replace(' ', '', $this->base->nombre) . '_turno_' . $this->turno->codigo . '.xls';
    }

    private function getDataForTemplate(): Collection
    {
        $date = new \DateTime();
        $header = [
            'Nombre',
            'Apellido',
            'CUIT',
            $date->format('Y-m-d'),
            $date->modify('-1 day')->format('Y-m-d'),
            $date->modify('-1 day')->format('Y-m-d'),
            $date->modify('-1 day')->format('Y-m-d'),
            $date->modify('-1 day')->format('Y-m-d'),
        ];

        $operativos = AgenteRepository::getAgentesByBaseByTurno($this->base, $this->turno);

        $data = collect();
        $data->push($header);

        foreach ($operativos as $operativo) {
            $data->push([
                $operativo->agente->nombre,
                $operativo->agente->apellido,
                $operativo->agente->cuit,
            ]);
        }
        return $data;
    }

}
