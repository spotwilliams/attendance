<?php

namespace Cat\Modules\Haberes\Controllers\Notificacion;

use Cat\Models\Notificacion;
use Cat\Models\Periodo;
use Cat\Modules\Haberes\Services\Calculo\Calculador;
use Cat\Modules\Haberes\Services\Sender\Sender;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Krucas\Notification\Facades\Notification;
use Laracasts\Flash\Flash;
use Cat\Modules\Haberes\Controllers\GeneralController;
use Cat\Modules\Haberes\Controllers\Eloquenteable;

class Regular extends Sender
{
    use Eloquenteable;
    
    public function __construct(
        Periodo $periodo,
        Collection $agentes
    ) {
        parent::__construct(
            $periodo,
            $agentes,
            'Haberes::mails.regular'
        );
        
    }
    
    public function execute()
    {
        $this->send();
    }
    
    
}
