<?php

namespace App\Http\Controllers\Admin;

use App\RetreatApplication;
use App\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\RetreatApplicationStoreRequest as StoreRequest;
use App\Http\Requests\RetreatApplicationUpdateRequest as UpdateRequest;
use Carbon\Carbon;

class RetreatApplicationCrudController extends CrudController
{
    public function setup()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel(RetreatApplication::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/retreat-application');
        $this->crud->setEntityNameStrings('Retreat Application', 'Retreat Applications');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        $this->crud->addColumns([
            [
                'name' => 'user_id',
                'label' => '이름',
                'type' => 'select',
                'entity' => 'user',
                'model' => User::class,
                'attribute' => 'name'
            ],
            [
                'name' => 'term_name',
                'label' => '텀'
            ],
            [
                'name' => 'is_paid',
                'label' => '결제여부',
                'type' => 'boolean'  ,
                'options' => [
                    0 => '미납',
                    1 => '완납'
                ]
            ],
            [
                'name' => 'created_at',
                'label' => '신청일',
                'type' => 'date'
            ]

        ]);



        $fields = [
            [
                'name' => 'uniform_size',
                'label' => '유니폼 사이즈',
                'type' => 'select2_from_array',
                'options' => [
                    'XS' => 'XS',
                    'S' => 'S',
                    'M' => 'M',
                    'L' => 'L',
                    'XL' => 'XL',
                    'XXL' => 'XXL'
                ],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name' => 'price',
                'label' => '가격',
                'type' => 'number',
                'attributes' => ['step' => '1'],
                'prefix' => '$',
                'suffix' => '.00',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name' => 's1',
                'type' => 'custom_html',
                'value' => '<hr/>'
            ],
            [
                'name' => 'is_paid',
                'label' => '결제여부',
                'type' => 'radio',
                'options' => [
                    0 => '미납',
                    1 => '완납'
                ],
                'inline' => true,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ]
            ],
            [
                'name' => 'payment_method',
                'label' => '결제방법',
                'type' => 'select_from_array',
                'options' => [
                    '' => '-',
                    'Cash' => 'Cash',
                    'Check' => 'Check'
                ],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ]
            ],
            [
                'name' => 'paid_at',
                'label' => '결제날짜',
                'type' => 'date',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ]
            ],
            [
                'name' => 's2',
                'type' => 'custom_html',
                'value' => '<hr/>'
            ],
            [
                'name' => 'group',
                'label' => '조',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name' => 'room',
                'label' => '방',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name' => 's3',
                'type' => 'custom_html',
                'value' => '<hr/>'
            ],
            [
                'name' => 'note',
                'label' => '노트',
                'type' => 'textarea',
                'attributes' => ['rows' => 5]
            ]
        ];



        $this->crud->addFields(array_merge([], [
            [
                'name' => 'term',
                'label' => '텀',
                'type' => 'select_from_array',
                'options' => [
                    '17_W' => '2017 겨울 수련회',
                    '18_S' => '2018 여름 수련회'
                ],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ]
            ],
            [
                'name' => 's0',
                'type' => 'custom_html',
                'value' => '<hr/>'
            ],
            [
                'name' => 'user_id',
                'label' => '이름',
                'type' => 'select2',
                'entity' => 'user',
                'model' => User::class,
                'attribute' => 'name'
            ],
        ], $fields), 'create');

        $this->crud->addFields(array_merge([], [
            [
                'name' => 'users_name',
                'label' => '이름',
                'type' => 'text',
                'attributes' => ['readonly' => 'readonly']
            ],
        ], $fields), 'update');






        $this->crud->orderBy('created_at', 'desc');

        $this->crud->addFilter([
            'type' => 'dropdown',
            'name' => 'term',
            'label' => 'Term'
        ], [
            '17_W' => '2017 겨울 수련회',
            '18_S' => '2108 여름 수련회'
        ], function($value){
            $this->crud->addClause('where', 'term', $value);
        });

        $this->crud->enableDetailsRow();
        $this->crud->allowAccess('details_row');


        //$this->crud->addButton('top', 'status', 'model_function', 'statusButton', 'end');
        //$this->crud->addButton('top', 'print', 'model_function', 'printButton', 'end');






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


    public function showDetailsRow($id)
    {
        $app = RetreatApplication::with('user.profile.phone', 'user.profile.address')->find($id);
        $profile = (object)$app->user->parseProfile();

        $data = [
            '이름' => $profile->name,
            '신청일' => $app->created_at->format('Y-m-d'),
            '이메일' => $profile->email,
            '성별' => $profile->gender,
            '생일' => $profile->birthday,
            '나이' => $profile->age,
            '전화번호' => $profile->phone,
            '주소' => $profile->address,
            '사이즈' => $app->uniform_size,
            '가격' => $app->price,
            '결제여부' => $app->is_paid? '완납' : '미납',
            '결제날짜' => $app->paid_at? $app->paid_at->format('Y-m-d'): '-',
            '조' => $app->group?: '-',
            '방' => $app->room?: '-',
            '노트' => $app->note?: '-'
        ];

        return view('retreat-application.detail', compact('data'));
    }





}
