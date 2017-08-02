<?php $bases = \Cat\Repositories\BaseRepository::getAll() ?>

<div class="form-horizontal">
    <div class="form-group">
        <label class="col-sm-2 col-xs-2 control-label">{{$label}}</label>
        <div class="col-sm-6 col-xs-6">
            <select class="form-control" id="base-select-with-button">

                @foreach ($bases as $base)
                    <option value="{{ $base->id }}" {{($baseSeleccionada == $base->id) ? 'selected': ''}}>{!! $base->nombre !!}</option>
                @endforeach
            </select>
        </div>
        <a class="btn btn-primary col-sm-2 col-xs-2" id="go-to-base">Ver base</a>
    </div>
</div>

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var url = "{{route($routeName, 'replace')}}";
            var element = $('#base-select-with-button');
            $(element).on('change', function () {
                $('#go-to-base').attr('href', url.replace('replace', element.val()));
            })
        });
    </script>
@append
