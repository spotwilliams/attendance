<?php
/**
 * Created by PhpStorm.
 * User: worker
 * Date: 5/5/17
 * Time: 11:19
 */

namespace Cat\Modules\Haberes\Services\Calculo;

use Cat\Models\Agente;
use Cat\Models\Base;
use Cat\Models\Periodo;
use Cat\Models\Presentismo;
use Cat\Models\TipoPresentismo;
use Cat\Models\Turno;
use Cat\Modules\Service;
use Cat\Modules\Validation\Repositories\PresentismoRepository;
use Illuminate\Http\UploadedFile;

class Reporte extends Service
{
    
    /** @var  Base */
    protected $base;
    
    /** @var  Periodo */
    protected $periodo;
    
    /** @var  Turno */
    protected $turno;
    
    /** @var  UploadedFile */
    protected $file;
    
    
    public function __construct(Base $base, Periodo $periodo, Turno $turno, UploadedFile $file)
    {
        $this->base          = $base;
        $this->periodo       = $periodo;
        $this->turno         = $turno;
        $this->file          = $file;
    }
    
    
    /**
     * @return bool
     */
    public function execute()
    {
    
    
    }
    
    
}