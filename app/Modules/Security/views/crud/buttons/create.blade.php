@if ($crud->hasAccess('create'))
    @if ($crud->hasAccess('create'))
        <a href="{{ url($crud->route.'/create') }}" class="btn btn-success" data-style="zoom-in"><span class="ladda-label"> Agregar nuevo {{ $crud->entity_name }}</span></a>
    @endif
@endif