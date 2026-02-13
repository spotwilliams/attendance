<?php

namespace Cat\Modules\Reportes\Exports;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReporteExport implements FromCollection, WithHeadings, Responsable
{
    private Collection $data;
    private array $headings;
    public $fileName = 'Reporte.xlsx';

    public function __construct(Collection $data, array $headings = [])
    {
        $this->data = $data;
        $this->headings = $headings;
    }

    public function collection(): Collection
    {
        return $this->data;
    }

    public function headings(): array
    {
        return $this->headings;
    }

    public function toResponse($request): BinaryFileResponse
    {
        return \Maatwebsite\Excel\Facades\Excel::download($this, $this->fileName);
    }
}
