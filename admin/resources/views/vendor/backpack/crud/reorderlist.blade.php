@extends('backpack::layout')

@section('header')
<section class="content-header">
    <h1>
        <span class="text-capitalize">{{ $crud->entity_name_plural }}</span>
        <small>{{ trans('backpack::crud.all') }} <span>{{ $crud->entity_name_plural }}</span> {{ trans('backpack::crud.in_the_database') }}.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
        <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
        <li class="active">{{ trans('backpack::crud.list') }}</li>
    </ol>
</section>
@endsection

@section('content')
<?php
function tree_element($entry, $key, $all_entries, $crud)
{
    if (!isset($entry->tree_element_shown)) {
        // mark the element as shown
        $all_entries[$key]->tree_element_shown = true;
        $entry->tree_element_shown = true;

        $actions = $crud->buttons->where('stack', 'line')->count();
        $actionHtml = '';
        if($actions){
            $actionHtml = View::make('crud::inc.button_stack', ['stack' => 'line', 'crud' => $crud, 'entry' => $entry]);
            $actionHtml = '<span style="float:right">' . $actionHtml->render() . '</span>';
        }


        // show the tree element
        echo '<li id="list_'.$entry->getKey().'">';


        if(preg_match('#(\.jpg|\.png)#i', object_get($entry, $crud->reorder_label))){
            echo '<div style="height:62px;padding-left:62px;position:relative;"><span style="position:absolute;left:6px;top:6px;width:50px;height:50px;background:url('.url(object_get($entry, $crud->reorder_label)).') 50% 50% no-repeat;background-size:cover;display:block;"></span><span class="disclose"><span></span></span>'.object_get($entry, $crud->reorder_label).$actionHtml.'</div>';
        }

        else {
            echo '<div style="position:relative"><span class="disclose"><span></span></span>'.object_get($entry, $crud->reorder_label).$actionHtml.'</div>';

        }


        // see if this element has any children
        $children = [];
        foreach ($all_entries as $key => $subentry) {
            if ($subentry->parent_id == $entry->getKey()) {
                $children[] = $subentry;
            }
        }

        $children = collect($children)->sortBy('lft');

        // if it does have children, show them
        if (count($children)) {
            echo '<ol>';
            foreach ($children as $key => $child) {
                $children[$key] = tree_element($child, $child->getKey(), $all_entries, $crud);
            }
            echo '</ol>';
        }
        echo '</li>';
    }

    return $entry;
}

?>
<div class="row">
    <div class="col-md-12">

        <!-- Default box -->
        <div class="box">

            <div class="box-header with-border">
                @include('crud::inc.button_stack', ['stack' => 'top'])
                <div id="datatable_button_stack" class="pull-right text-right"></div>
            </div>

            <div class="box-body">

                <p>{{ trans('backpack::crud.reorder_text') }}</p>

                <ol class="sortable">
                <?php
                    $all_entries = collect($entries->all())->sortBy('lft')->keyBy($crud->getModel()->getKeyName());
                    $root_entries = $all_entries->filter(function ($item) {
                        return $item->parent_id == 0;
                    });
                    foreach ($root_entries as $key => $entry){
                        $root_entries[$key] = tree_element($entry, $key, $all_entries, $crud);
                    }
                ?>
                </ol>

                <button id="toArray" class="btn btn-success ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-save"></i> {{ trans('backpack::crud.save') }}</span></button>

            </div><!-- /.box-body -->

            @include('crud::inc.button_stack', ['stack' => 'bottom'])

        </div><!-- /.box -->
    </div>
</div>
@endsection


@section('after_styles')
<link rel="stylesheet" href="{{ asset('vendor/backpack/nestedSortable/nestedSortable.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/crud.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/reorder.css') }}">
@endsection

@section('after_scripts')
<script src="{{ asset('vendor/backpack/crud/js/crud.js') }}"></script>
<script src="{{ asset('vendor/backpack/crud/js/reorder.js') }}"></script>
<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js" type="text/javascript"></script>
<script src="{{ url('vendor/backpack/nestedSortable/jquery.mjs.nestedSortable2.js') }}" type="text/javascript"></script>

<script type="text/javascript">
    jQuery(document).ready(function($) {

    // initialize the nested sortable plugin
    $('.sortable').nestedSortable({
        forcePlaceholderSize: true,
        handle: 'div',
        helper: 'clone',
        items: 'li',
        opacity: .6,
        placeholder: 'placeholder',
        revert: 250,
        tabSize: 25,
        tolerance: 'pointer',
        toleranceElement: '> div',
        maxLevels: {{ $crud->reorder_max_level or 3 }},

        isTree: true,
        expandOnHover: 700,
        startCollapsed: false
    });

    $('.disclose').on('click', function() {
        $(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
    });

    $('#toArray').click(function(e){
        // get the current tree order
        arraied = $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0});

        // log it
        //console.log(arraied);

        // send it with POST
        $.ajax({
            url: '{{ Request::url() . '/reorder' }}',
            type: 'POST',
            data: { tree: arraied },
        })
        .done(function() {
            //console.log("success");
            new PNotify({
                        title: "{{ trans('backpack::crud.reorder_success_title') }}",
                        text: "{{ trans('backpack::crud.reorder_success_message') }}",
                        type: "success"
                    });
          })
        .fail(function(e) {
            console.log(e);
            new PNotify({
                        title: "{{ trans('backpack::crud.reorder_error_title') }}",
                        text: "{{ trans('backpack::crud.reorder_error_message') }}",
                        type: "danger"
                    });
          })
        .always(function() {
            console.log("complete");
        });

    });

    $.ajaxPrefilter(function(options, originalOptions, xhr) {
        var token = $('meta[name="csrf_token"]').attr('content');

        if (token) {
            return xhr.setRequestHeader('X-XSRF-TOKEN', token);
        }
    });



    // make the delete button work in the first result page
    register_delete_button_action();


    function register_delete_button_action() {
        $("[data-button-type=delete]").unbind('click');
        // CRUD Delete
        // ask for confirmation before deleting an item
        $("[data-button-type=delete]").click(function(e) {
            e.preventDefault();
            var delete_button = $(this);
            var delete_url = $(this).attr('href');

            if (confirm("{{ trans('backpack::crud.delete_confirm') }}") == true) {
                $.ajax({
                    url: delete_url,
                    type: 'DELETE',
                    success: function(result) {

                        // Show an alert with the result
                        new PNotify({
                            title: "{{ trans('backpack::crud.delete_confirmation_title') }}",
                            text: "{{ trans('backpack::crud.delete_confirmation_message') }}",
                            type: "success"
                        });
                        // delete the row from the table
                        delete_button.parentsUntil('li').remove();
                    },
                    error: function(result) {
                        // Show an alert with the result
                        new PNotify({
                            title: "{{ trans('backpack::crud.delete_confirmation_not_title') }}",
                            text: "{{ trans('backpack::crud.delete_confirmation_not_message') }}",
                            type: "warning"
                        });
                    }
                });
            } else {
                new PNotify({
                    title: "{{ trans('backpack::crud.delete_confirmation_not_deleted_title') }}",
                    text: "{{ trans('backpack::crud.delete_confirmation_not_deleted_message') }}",
                    type: "info"
                });
            }
        });
    }



});
</script>
@endsection
