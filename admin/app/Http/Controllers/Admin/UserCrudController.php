<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\User;
use App\UserProfile;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\UserStoreCrudRequest as StoreRequest;
// VALIDATION
use App\Http\Requests\UserUpdateCrudRequest as UpdateRequest;
use Illuminate\Http\Request;
use App\Helper\Address;


class UserCrudController extends CrudController
{
    public function __construct()
    {
        $this->middleware('can:manage admin');
        parent::__construct();
    }


    public function setup()
    {
        $this->crud->setModel(config('backpack.permissionmanager.user_model'));
        $this->crud->setEntityNameStrings(trans('backpack::permissionmanager.user'), trans('backpack::permissionmanager.users'));
        $this->crud->setRoute(config('backpack.base.route_prefix').'/user');
        //$this->crud->enableAjaxTable();

        $this->crud->setColumns([
            [
                'name'  => 'email',
                'label' => trans('backpack::permissionmanager.email'),
                'type'  => 'email',
            ],
            [
                'name' => 'name'
            ]
        ]);



        $this->crud->addColumn([ // n-n relationship (with pivot table)
           'label'     => trans('backpack::permissionmanager.roles'), // Table column heading
           'type'      => 'select_multiple',
           'name'      => 'roles', // the method that defines the relationship in your Model
           'entity'    => 'roles', // the method that defines the relationship in your Model
           'attribute' => 'name', // foreign key attribute that is shown to user
           'model'     => "App\Roles", // foreign key model
        ]);

        /*$this->crud->addColumn([ // n-n relationship (with pivot table)
           'label'     => trans('backpack::permissionmanager.extra_permissions'), // Table column heading
           'type'      => 'select_multiple',
           'name'      => 'permissions', // the method that defines the relationship in your Model
           'entity'    => 'permissions', // the method that defines the relationship in your Model
           'attribute' => 'name', // foreign key attribute that is shown to user
           'model'     => "App\Permission", // foreign key model
        ]);*/

        $this->crud->addButton('line', 'profile', 'model_function', 'profileButton', 'beginning');





        $this->crud->addFields([
            [
                'name' => 'separator0',
                'type' => 'custom_html',
                'value' => '<div><h4>Login Info</h4></div>',
            ],
            [
                'name'  => 'email',
                'label' => trans('backpack::permissionmanager.email'),
                'type'  => 'email',
            ],
            [
                'name'  => 'password',
                'label' => trans('backpack::permissionmanager.password'),
                'type'  => 'password',
            ],
            [
                'name'  => 'password_confirmation',
                'label' => trans('backpack::permissionmanager.password_confirmation'),
                'type'  => 'password',
            ],



            [
                'name' => 'separator2',
                'type' => 'custom_html',
                'value' => '<div><hr/><h4>Roles & Permissions</h4></div>',
            ],

            [
            // two interconnected entities
            'label'             => '',
            'field_unique_name' => 'user_role_permission',
            'type'              => 'checklist_dependency',
            'name'              => 'roles_and_permissions', // the methods that defines the relationship in your Model
            'subfields'         => [
                    'primary' => [
                        'label'            => trans('backpack::permissionmanager.roles'),
                        'name'             => 'roles', // the method that defines the relationship in your Model
                        'entity'           => 'roles', // the method that defines the relationship in your Model
                        'entity_secondary' => 'permissions', // the method that defines the relationship in your Model
                        'attribute'        => 'name', // foreign key attribute that is shown to user
                        'model'            => "App\Role", // foreign key model
                        'pivot'            => true, // on create&update, do you need to add/delete pivot table entries?]
                        'number_columns'   => 3, //can be 1,2,3,4,6
                    ],
                    'secondary' => [
                        'label'          => ucfirst(trans('backpack::permissionmanager.permission_singular')),
                        'name'           => 'permissions', // the method that defines the relationship in your Model
                        'entity'         => 'permissions', // the method that defines the relationship in your Model
                        'entity_primary' => 'roles', // the method that defines the relationship in your Model
                        'attribute'      => 'name', // foreign key attribute that is shown to user
                        'model'          => "App\Permission", // foreign key model
                        'pivot'          => true, // on create&update, do you need to add/delete pivot table entries?]
                        'number_columns' => 3, //can be 1,2,3,4,6
                    ],
                ],
            ],


        ]);


        $this->crud->orderBy('created_at', 'desc');
        //$this->crud->enableAjaxTable();



    }

    /**
     * Store a newly created resource in the database.
     *
     * @param StoreRequest $request - type injection used for validation using Requests
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        $this->crud->hasAccessOrFail('create');


        // insert item in the db
        if ($request->input('password')) {
            $item = $this->crud->create($request->except(['redirect_after_save']));

            // now bcrypt the password
            $item->password = bcrypt($request->input('password'));
            $item->save();
        } else {
            $item = $this->crud->create($request->except(['redirect_after_save', 'password']));
        }

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->setSaveAction();

        return $this->performSaveAction($item->getKey());
    }




    public function update(UpdateRequest $request)
    {
        //encrypt password and set it to request
        $this->crud->hasAccessOrFail('update');

        $dataToUpdate = $request->except(['redirect_after_save', 'password']);


        //encrypt password
        if ($request->input('password')) {
            $dataToUpdate['password'] = bcrypt($request->input('password'));
        }


        // update the row in the db
        $this->crud->update(\Request::get($this->crud->model->getKeyName()), $dataToUpdate);

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->setSaveAction();

        return $this->performSaveAction();
    }


}
