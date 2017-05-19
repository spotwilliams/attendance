<?php
/** @var  \Cat\Models\TipoPresentismo $tiposPresentismo */
$tiposPresentismo = \Cat\Models\TipoPresentismo::all();

/** @var  string $label Param del include de la vista */
?>

<div class="form-group">
    @if(isset($label))
        <label class="col-sm-2 control-label">{{$label}}</label>
    @endif
    <div class="input-group margin">
        <select class="{{$classSelector}} form-control"
                data-width="80px"
        >
            <option value="-1">...</option>
            @foreach ($tiposPresentismo as $tipo)
                <option
                        value="{{ $tipo->id }}"
                        data-content="<span class='label' style='background-color: {{$tipo->color}};'>{{$tipo->descripcion}}</span>"
                >{!! $tipo->descripcion !!}</option>
            @endforeach
        </select>
        <div class="input-group-btn">
            <button type="button" class="btn btn-success">
                <i class="fa fa-commenting"></i>
            </button>
            @if(isset($buttons))
                <button type="button"
                        class="btn btn-primary dropdown-toggle"
                        data-toggle="dropdown"
                        aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu">

                    @if(in_array('edit',$buttons))
                        <li>
                            <a href="#">
                                <i class="fa fa-pencil"></i> Editar
                            </a>
                        </li>
                    @endif
                </ul>
            @endif
        </div>
    </div>
</div>

