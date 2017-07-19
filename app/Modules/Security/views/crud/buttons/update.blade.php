@if ($crud->hasAccess('update'))
    <a href="{{ url($crud->route.'/'.$entry->getKey()) }}/edit" class="btn btn-primary" data-toggle="tooltip"
       data-placement="top" title="" data-original-title="Editar">
        <i class="fa fa-edit"></i>
    </a>
@endif