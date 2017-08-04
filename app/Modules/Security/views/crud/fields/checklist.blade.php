<!-- select2 -->
<div @include('Security::crud.inc.field_wrapper_attributes') >
    <label>{{ $field['label'] }}</label>
    <?php $entity_model = $crud->getModel();?>

    <div class="row">
        <div class="col-sm-12">
            <a class="btn btn-default all-select">
                <span class="label label-info">Marcar Todas</span>
            </a>
            <a class="btn btn-default none-select">
                <span class="label label-info">Desmarcar todas</span>
            </a>
        </div>
        @foreach ($field['model']::all() as $connected_entity_entry)
            <div class="col-sm-4">
                <div class="checkbox checkbox-info checkbox-circle">
                    <input type="checkbox"
                           class="selectable"
                           id="chk_{{$field['model']}}_{{$connected_entity_entry->id}}"
                           name="{{ $field['name'] }}[]"
                           value="{{ $connected_entity_entry->id }}"
                           @if( ( old( $field["name"] ) && in_array($connected_entity_entry->id, old( $field["name"])) ) || (isset($field['value']) && in_array($connected_entity_entry->id, $field['value']->pluck('id', 'id')->toArray())))
                           checked="checked"
                            @endif >
                    <label for="chk_{{$field['model']}}_{{$connected_entity_entry->id}}">
                        {{ $connected_entity_entry->{$field['attribute']} }}
                    </label>
                </div>
            </div>
        @endforeach
    </div>
</div>

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {

            $('.all-select').off().on('click', function () {

                $(this)
                    .parents('.row')
                    .first()
                    .find('input[type="checkbox"]')
                    .prop('checked', true)
                ;

            });
            $('.none-select').on('click', function () {
                $(this)
                    .parents('.row')
                    .first()
                    .find('input[type="checkbox"]')
                    .prop('checked', false)
                ;

            })
        })
    </script>
@append