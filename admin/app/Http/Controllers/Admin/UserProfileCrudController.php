<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Address;
use App\Phonebook;
use App\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\UserProfileRequest as StoreRequest;
use App\Http\Requests\UserProfileRequest as UpdateRequest;

class UserProfileCrudController extends CrudController
{
    public function setup()
    {
        $user = User::find(request()->get('user_id'));


        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\UserProfile');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/profile');
        $this->crud->setEntityNameStrings('User Profile', 'User Profiles');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        //$this->crud->setFromDb();


        $basic = [
            [
                'name' => 'separator0',
                'type' => 'custom_html',
                'value' => '<div><h4>Basic Info</h4></div>',
            ],
            [
                'name' => 'user_id',
                'type' => 'hidden',
                'value' => $user->id
            ],
            [
                'name' => 'name'
            ],
            [
                'name' => 'gender',
                'type' => 'select_from_array',
                'options' => [
                    'male' => 'Male',
                    'female' => 'Female'
                ],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ]
            ],
            [
                'name' => 'birthday',
                'type' => 'date',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ]
            ]
        ];


        $value = '';
        if($user->profile && $user->profile->phone){ // edit & phone exist
            $url = url("phonebook/{$user->profile->phone->id}/edit?profile_id={$user->profile->id}");
            $value .= '<a href="'.$url.'" class="btn btn-primary">View/Edit Phone Number</a> ';
        }
        elseif($user->profile){ // edit & phone does not exist
            $url = url("phonebook/create?profile_id={$user->profile->id}");
            $value .= '<a href="'.$url.'" class="btn btn-primary">Add Phone Number</a> ';
        }

        if($user->profile && $user->profile->address){ // edit & phone exist
            $url = url("addressbook/{$user->profile->address->id}/edit?profile_id={$user->profile->id}");
            $value .= '<a href="'.$url.'" class="btn btn-primary">View/Edit Address</a> ';
        }
        elseif($user->profile){ // edit & phone does not exist
            $url = url("addressbook/create?profile_id={$user->profile->id}");
            $value .= '<a href="'.$url.'" class="btn btn-primary">Add Address</a> ';
        }
        if($value){
            $basic[] = [
                'name' => 'buttons',
                'type' => 'custom_html',
                'value' => $value
            ];
        }



        $this->crud->addFields($basic);


        // ------ CRUD FIELDS
        // $this->crud->addField($options, 'update/create/both');
        // $this->crud->addFields($array_of_arrays, 'update/create/both');
        // $this->crud->removeField('name', 'update/create/both');
        // $this->crud->removeFields($array_of_names, 'update/create/both');

        // ------ CRUD COLUMNS
        // $this->crud->addColumn(); // add a single column, at the end of the stack
        // $this->crud->addColumns(); // add multiple columns, at the end of the stack
        // $this->crud->removeColumn('column_name'); // remove a column from the stack
        // $this->crud->removeColumns(['column_name_1', 'column_name_2']); // remove an array of columns from the stack
        // $this->crud->setColumnDetails('column_name', ['attribute' => 'value']); // adjusts the properties of the passed in column (by name)
        // $this->crud->setColumnsDetails(['column_1', 'column_2'], ['attribute' => 'value']);

        // ------ CRUD BUTTONS
        // possible positions: 'beginning' and 'end'; defaults to 'beginning' for the 'line' stack, 'end' for the others;
        // $this->crud->addButton($stack, $name, $type, $content, $position); // add a button; possible types are: view, model_function
        // $this->crud->addButtonFromModelFunction($stack, $name, $model_function_name, $position); // add a button whose HTML is returned by a method in the CRUD model
        // $this->crud->addButtonFromView($stack, $name, $view, $position); // add a button whose HTML is in a view placed at resources\views\vendor\backpack\crud\buttons
        // $this->crud->removeButton($name);
        // $this->crud->removeButtonFromStack($name, $stack);
        // $this->crud->removeAllButtons();
        // $this->crud->removeAllButtonsFromStack('line');

        // ------ CRUD ACCESS
        // $this->crud->allowAccess(['list', 'create', 'update', 'reorder', 'delete']);
        // $this->crud->denyAccess(['list', 'create', 'update', 'reorder', 'delete']);

        // ------ CRUD REORDER
        // $this->crud->enableReorder('label_name', MAX_TREE_LEVEL);
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('reorder');

        // ------ CRUD DETAILS ROW
        // $this->crud->enableDetailsRow();
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('details_row');
        // NOTE: you also need to do overwrite the showDetailsRow($id) method in your EntityCrudController to show whatever you'd like in the details row OR overwrite the views/backpack/crud/details_row.blade.php

        // ------ REVISIONS
        // You also need to use \Venturecraft\Revisionable\RevisionableTrait;
        // Please check out: https://laravel-backpack.readme.io/docs/crud#revisions
        // $this->crud->allowAccess('revisions');

        // ------ AJAX TABLE VIEW
        // Please note the drawbacks of this though:
        // - 1-n and n-n columns are not searchable
        // - date and datetime columns won't be sortable anymore
        // $this->crud->enableAjaxTable();

        // ------ DATATABLE EXPORT BUTTONS
        // Show export to PDF, CSV, XLS and Print buttons on the table view.
        // Does not work well with AJAX datatables.
        // $this->crud->enableExportButtons();

        // ------ ADVANCED QUERIES
        // $this->crud->addClause('active');
        // $this->crud->addClause('type', 'car');
        // $this->crud->addClause('where', 'name', '==', 'car');
        // $this->crud->addClause('whereName', 'car');
        // $this->crud->addClause('whereHas', 'posts', function($query) {
        //     $query->activePosts();
        // });
        // $this->crud->addClause('withoutGlobalScopes');
        // $this->crud->addClause('withoutGlobalScope', VisibleScope::class);
        // $this->crud->with(); // eager load relationships
        // $this->crud->orderBy();
        // $this->crud->groupBy();
        // $this->crud->limit();
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry

        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry

        return $redirect_location;
    }

    public function performSaveAction($itemId = null)
    {
        $saveAction = \Request::input('save_action', config('backpack.crud.default_save_action', 'save_and_back'));
        $itemId = $itemId ? $itemId : \Request::input('id');

        switch ($saveAction) {
            case 'save_and_new':
                $redirectUrl = $this->crud->route.'/create';
                break;
            case 'save_and_edit':
                $redirectUrl = $this->crud->route.'/'.$itemId.'/edit';
                if (\Request::has('locale')) {
                    $redirectUrl .= '?locale='.\Request::input('locale');
                }
                break;
            case 'save_and_back':
            default:
                $redirectUrl = url('user');
                //$redirectUrl = $this->crud->route;
                break;
        }

        return \Redirect::to($redirectUrl);
    }
}
