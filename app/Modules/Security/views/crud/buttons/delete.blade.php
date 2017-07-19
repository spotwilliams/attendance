@if ($crud->hasAccess('delete'))
	<a href="{{ url($crud->route.'/'.$entry->getKey()) }}" class="btn btn-danger" data-toggle="tooltip"
	   data-placement="top" title="" data-original-title="Eliminar">
		<i class="fa fa-remove"></i>
	</a>
@endif