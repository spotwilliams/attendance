
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="{{ Request::is('*by/agente') ? 'true' : 'false' }}" aria-controls="collapseOne">
                   >> Buscar por agentes
                </a>
            </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse {{ Request::is('*by/agente') ? 'in' : '' }}" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                @include('Haberes::notificacion.parts.by-agente')
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingTwo">
            <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="{{ Request::is('*by/filtros') ? 'true' : 'false' }}" aria-controls="collapseTwo">
                   >> Buscar por filtros
                </a>
            </h4>
        </div>
        <div id="collapseTwo" class="panel-collapse collapse {{ Request::is('*by/filtros') ? 'in' : '' }}" role="tabpanel" aria-labelledby="headingTwo">
            <div class="panel-body">
                @include('Haberes::notificacion.parts.by-filtros')

            </div>
        </div>
    </div>

</div>

