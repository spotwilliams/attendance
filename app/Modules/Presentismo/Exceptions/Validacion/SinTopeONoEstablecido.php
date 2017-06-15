<?php
/**
 * Created by PhpStorm.
 * User: worker
 * Date: 6/14/17
 * Time: 15:00
 */

namespace Cat\Modules\Presentismo\Exceptions\Validacion;


use Cat\Models\TipoPresentismo;

class SinTopeONoEstablecido extends \Exception
{
    protected $tipoPresentismo;
    /** @var  Descriptor */
    protected $errorDescriptor;
    
    public function __construct(TipoPresentismo $tipoPresentismo)
    {
        $this->tipoPresentismo = $tipoPresentismo;
        $this->errorDescriptor = Descriptor::presentismoSinDiasConfigurados($tipoPresentismo);
        $message               = $this->errorDescriptor->getDescription();
        $code                  = $this->errorDescriptor->getCode();
        parent::__construct($message, $code, $this);
    }
}