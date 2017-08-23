{{--Added orderBy, orderByDirection to original--}}


<!-- select2 multiple -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')
    <select
        name="{{ $field['name'] }}[]"
        style="width: 100%"
        @include('crud::inc.field_attributes', ['default_class' =>  'form-control select2_multiple'])
        multiple>

        @if (isset($field['model']))

            @php
            if(isset($field['orderBy']) && isset($field['orderByDirection'])){
                $connected_entities = $field['model']::orderBy($field['orderBy'], $field['orderByDirection'])->get();
            }
            elseif(isset($field['orderBy'])){
                $connected_entities = $field['model']::orderBy($field['orderBy'])->get();
            }
            else {
                $connected_entities = $field['model']::all();
            }
            @endphp

            @foreach ($connected_entities as $connected_entity_entry)
                <option value="{{ $connected_entity_entry->getKey() }}"
                    @if ( (isset($field['value']) && in_array($connected_entity_entry->getKey(), $field['value']->pluck($connected_entity_entry->getKeyName(), $connected_entity_entry->getKeyName())->toArray())) || ( old( $field["name"] ) && in_array($connected_entity_entry->getKey(), old( $field["name"])) ) )
                         selected
                    @endif
                >{{ $connected_entity_entry->{$field['attribute']} }}</option>
            @endforeach
        @endif
    </select>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>


{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
        <!-- include select2 css-->
        <link href="{{ asset('vendor/adminlte/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
        {{-- <link href="{{ asset('vendor/backpack/select2/select2-bootstrap-dick.css') }}" rel="stylesheet" type="text/css" /> --}}
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        <!-- include select2 js-->
        <script src="{{ asset('vendor/adminlte/plugins/select2/select2.min.js') }}"></script>
        <script>
            jQuery(document).ready(function($) {
                // trigger select2 for each untriggered select2_multiple box
                $('.select2_multiple').each(function (i, obj) {
                    if (!$(obj).hasClass("select2-hidden-accessible"))
                    {
                        $(obj).select2({
                            theme: "bootstrap"
                        });
                    }
                });
            });
        </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
