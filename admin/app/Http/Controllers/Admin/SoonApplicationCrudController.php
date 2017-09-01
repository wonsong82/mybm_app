<?php

namespace App\Http\Controllers\Admin;

use App\SoonApplication;
use App\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\SoonApplicationRequest as StoreRequest;
use App\Http\Requests\SoonApplicationRequest as UpdateRequest;
use Carbon\Carbon;

class SoonApplicationCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\SoonApplication');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/soon-application');
        $this->crud->setEntityNameStrings('Soon Application', 'Soon Applications');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */


        $this->crud->addColumns([
            [
                'name' => 'user_id',
                'label' => 'User',
                'type' => 'select',
                'entity' => 'user',
                'model' => User::class,
                'attribute' => 'name'
            ],
            [
                'name' => 'term',
            ],
            [
                'name' => 'status'
            ],
            [
                'name' => 'created_at',
                'label' => 'Submitted on',
                'type' => 'date'
            ]
        ]);

        $this->crud->addFields([
            [
                'name' => 'user_id',
                'label' => 'User',
                'type' => 'select2',
                'entity' => 'user',
                'model' => User::class,
                'attribute' => 'name'
            ],
            [
                'name' => 'status',
                'type' => 'select_from_array',
                'options' => [
                    'pending' => 'Pending',
                    'accepted' => 'Accepted',
                    'canceled' => 'Canceled'
                ]
            ],
            [
                'name' => 'term',
                'type' => 'select_from_array',
                'options' => [
                    '2018' => '2017 - 2018',
                    '2019' => '2018 - 2019'
                ]
            ],
            [
                'name' => 'need_ride',
                'label' => 'Need Ride',
                'type' => 'checkbox',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ]
            ],
            [
                'name' => 'can_provide_ride',
                'label' => 'Can Provide Ride',
                'type' => 'checkbox',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ]
            ],
            [
                'name' => 'can_provide_place',
                'label' => 'Can Provide Place',
                'type' => 'checkbox',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ]
            ],
            [
                'name' => 'age_preference',
                'label' => 'Age Preference',
                'type' => 'select_from_array',
                'options' => [
                    'broad' => 'Broad range',
                    'exact' => 'Close range',
                    'both' => 'Can be both'
                ],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ]
            ]



        ]);


        //$this->crud->enableAjaxTable();
        $this->crud->orderBy('created_at', 'desc');


        $this->crud->addFilter([
            'type' => 'dropdown',
            'name' => 'term',
            'label' => 'Term'
        ], [
            '2018' => '2017 - 2018',
            //'2019' => '2018 - 2019'
        ], function($value){
            $this->crud->addClause('where', 'term', $value);
        });

        $this->crud->enableDetailsRow();
        $this->crud->allowAccess('details_row');


        $this->crud->addButton('top', 'status', 'model_function', 'statusButton', 'end');
        $this->crud->addButton('top', 'print', 'model_function', 'printButton', 'end');



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


    public function parseProfile($app)
    {
        $email = $app->user->email;
        $name = $app->user->profile->name;
        $birthday = $app->user->profile->birthday ?
            date('Y년 n월 j일', strtotime($app->user->profile->birthday))
            : '정보없음';
        $age = new Carbon($app->user->profile->birthday);
        $age = $app->user->profile->birthday ?
            $age->diffInYears() : '정보없음';
        $gender = $app->user->profile->gender == 'male' ? '남' : '여';
        $gender = $app->user->profile->gender ? $gender : '정보없음';
        $phone = $app->user->profile->phone ?
            sprintf('(%s) %s-%s',
                $app->user->profile->phone->area_code,
                $app->user->profile->phone->exchange,
                $app->user->profile->phone->line_number
            ) : '정보없음';
        $address = $app->user->profile->address ?
            sprintf('%s %s,<br>%s %s, %s',
                $app->user->profile->address->line1,
                $app->user->profile->address->line2,
                $app->user->profile->address->city,
                $app->user->profile->address->state,
                $app->user->profile->address->zip
            ) : '정보없음';

        return [
            'email' => $email,
            'name' => $name,
            'birthday' => $birthday,
            'age' => $age,
            'gender' => $gender,
            'phone' => $phone,
            'address' => $address
        ];
    }



    public function showDetailsRow($id)
    {
        $app = SoonApplication::with('user.profile.phone', 'user.profile.address')->find($id);
        extract($this->parseProfile($app));

        $data = [
            '이름' => $name,
            '이메일' => $email,
            '성별' => $gender,
            '생일' => $birthday,
            '나이' => $age,
            '전화번호' => $phone,
            '주소' => $address
        ];

        return view('soon-application.detail', compact('data'));
    }


    public function status($term)
    {
        $users = User::with('profile')->orderBy('created_at', 'desc')->get();

        $applications = SoonApplication::with('user.profile')->term($term)->get();

        $appliedUsers = $applications->map(function($application){
            return $application->user;
        });

        $notAppliedUsers = $users->diff($appliedUsers);

        $crud = $this->crud;


        return view('soon-application.status', compact('users', 'applications', 'appliedUsers', 'notAppliedUsers', 'term', 'crud'));
    }

    public function print($term)
    {
        $applications = SoonApplication::with('user.profile.phone', 'user.profile.address')->term($term)->get();

        $applications = $applications->map(function($app){
            $app->data = $this->parseProfile($app);
            return $app;
        });


        return view('soon-application.print', compact('applications'));
    }
}
