<?php

$periodosResumen = isset($periodosResumen) ? $periodosResumen : [];

?>
<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">Resumen</h3>
    </div>
    <div class="box-body">
        <div class="row">

            @foreach($periodosResumen as $pe)

                <div class="col-sm-4 col-xs-6">
                <span class="label">{{(new DateTime($pe->fecha_comienzo))->format('d/m/Y')}}
                hasta {{(new DateTime($pe->fecha_fin))->format('d/m/Y')}}</span>
                    @if($pe->abierto === true)
                    <div class="info-box bg-orange">
                        <span class="info-box-icon"><i class="fa fa-clock-o"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Abierto</span>
                            <span class="info-box-number">{{(new DateTime($pe->fecha_comienzo))->format('d/m/y')}}
                                al {{(new DateTime($pe->fecha_fin))->format('d/m/y')}}</span>
                            <span class="progress-description">Base: {{(\Cat\Models\Base::find($pe->id_base))->nombre}}. Turno: {{(\Cat\Models\Turno::find($pe->id_turno))->codigo}} </span>

                        </div>
                    </div>
                    @else
                        <div class="info-box bg-green">
                            <span class="info-box-icon"><i class="fa fa-check-circle"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Cerrado</span>
                                <span class="info-box-number">{{(new DateTime($pe->fecha_comienzo))->format('d/m/y')}}
                                    al {{(new DateTime($pe->fecha_fin))->format('d/m/y')}}</span>
                                <span class="progress-description">Base: {{(\Cat\Models\Base::find($pe->id_base))->nombre}}. Turno: {{(\Cat\Models\Turno::find($pe->id_turno))->codigo}} </span>
                            </div>
                        </div>
                    @endif
                </div>

            @endforeach
        </div>
    </div>

</div>
