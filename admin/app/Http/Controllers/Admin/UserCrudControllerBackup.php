<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Models\Partner;
use App\Models\Product;
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
        ]);

        $this->crud->addColumn([ // n-n relationship (with pivot table)
           'label'     => trans('backpack::permissionmanager.roles'), // Table column heading
           'type'      => 'select_multiple',
           'name'      => 'roles', // the method that defines the relationship in your Model
           'entity'    => 'roles', // the method that defines the relationship in your Model
           'attribute' => 'name', // foreign key attribute that is shown to user
           'model'     => "App\Models\Roles", // foreign key model
        ]);

        /*$this->crud->addColumn([ // n-n relationship (with pivot table)
           'label'     => trans('backpack::permissionmanager.extra_permissions'), // Table column heading
           'type'      => 'select_multiple',
           'name'      => 'permissions', // the method that defines the relationship in your Model
           'entity'    => 'permissions', // the method that defines the relationship in your Model
           'attribute' => 'name', // foreign key attribute that is shown to user
           'model'     => "App\Models\Permission", // foreign key model
        ]);*/



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
                'name' => 'verified',
                'label' => 'Email verified',
                'type' => 'checkbox'
            ],

            [
                'name' => 'separator1',
                'type' => 'custom_html',
                'value' => '<div><hr/><h4>User Profile</h4></div>',
            ],


            [
                'name'  => 'name',
                'label' => trans('backpack::permissionmanager.name'),
                'type'  => 'text',
            ],

            [
                'name' => 'phone_format',
                'label' => 'Phone Number',
                'type' => 'text',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-8'
                ]
            ],

            [
                'name' => 'phone_ext',
                'label' => 'Phone Extension Number',
                'type' => 'text',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ]
            ],

            [
                'name' => 'address_line1',
                'label' => 'Address Line1',
                'hint' => 'Street address, P.O. box, company name, c/o'
            ],
            [
                'name' => 'address_line2',
                'label' => 'Address Line2',
                'hint' => 'Apartment, suite, unit, building, floor, etc.'
            ],
            [
                'name' => 'address_city',
                'label' => 'City',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name' => 'address_state_us',
                'label' => 'State',
                'type' => 'select_from_array',
                'options' => Address::states(Address::ASSOC),
                'allows_null' => true,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name' => 'address_state_ca',
                'label' => 'Province',
                'type' => 'select_from_array',
                'options' => Address::canadaProvinces(Address::ASSOC),
                'allows_null' => true,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name' => 'address_zip_us',
                'label' => 'Zipcode',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name' => 'address_zip_ca',
                'label' => 'Postal Code',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name' => 'address_country',
                'label' => 'Country',
                'type' => 'select_from_array',
                'options' => [
                    'US' => 'United States',
                    'CA' => 'Canada'
                ],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ],


            [
                'name' => 'separator3',
                'type' => 'custom_html',
                'value' => '<div><hr/><h4>Dealer Section</h4></div>',
            ],

            [
                'name' => 'dealer_id',
                'label' => 'Associated dealer (if any)',
                'type' => 'select2',
                'entity' => 'dealer',
                'model' => Partner::class,
                'attribute' => 'name',
                'orderBy' => 'name',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name' => 'other_dealer_name',
                'label' => 'Other dealer (not listed yet)',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name' => 'title',
                'label' => 'Title',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ],


            [
                'name' => 'separator4',
                'type' => 'custom_html',
                'value' => '<div><hr/><h4>Doctor Section</h4></div>',
            ],

            [
                'name' => 'product_id',
                'label' => 'Associated product (if any)',
                'type' => 'select2',
                'entity' => 'product',
                'model' => Product::class,
                'attribute' => 'name',
                'orderBy' => 'name',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
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
                        'model'            => "App\Models\Role", // foreign key model
                        'pivot'            => true, // on create&update, do you need to add/delete pivot table entries?]
                        'number_columns'   => 3, //can be 1,2,3,4,6
                    ],
                    'secondary' => [
                        'label'          => ucfirst(trans('backpack::permissionmanager.permission_singular')),
                        'name'           => 'permissions', // the method that defines the relationship in your Model
                        'entity'         => 'permissions', // the method that defines the relationship in your Model
                        'entity_primary' => 'roles', // the method that defines the relationship in your Model
                        'attribute'      => 'name', // foreign key attribute that is shown to user
                        'model'          => "App\Models\Permission", // foreign key model
                        'pivot'          => true, // on create&update, do you need to add/delete pivot table entries?]
                        'number_columns' => 3, //can be 1,2,3,4,6
                    ],
                ],
            ],

            [
                'name' => 'condition',
                'type' => 'condition',
                'conditions' => [
                    [
                        'condition' => ['address_country', '=', 'US'],
                        'actions' => [
                            'address_state_us' => 'show',
                            'address_state_ca' => 'hide',
                            'address_zip_is' => 'show',
                            'address_zip_ca' => 'hide'
                        ]
                    ],
                    [
                        'condition' => ['address_country', '=', 'CA'],
                        'actions' => [
                            'address_state_us' => 'hide',
                            'address_state_ca' => 'show',
                            'address_zip_us' => 'hide',
                            'address_zip_ca' => 'show'
                        ]
                    ]
                ]
            ]
        ]);


        $this->crud->orderBy('created_at', 'desc');
        //$this->crud->enableAjaxTable();




        if(auth()->user()->can('manage administrations')) {
            $this->crud->allowAccess('revisions');
        }
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

        // address
        $request = $this->parseAddress($request);


        if($request->input('phone_format')){
            $phone = preg_replace('/[^0-9]/', '', trim($request->input('phone_format')));
            if(strlen($phone) == 10){
                $phone = '1' . $phone;
            }

            $request->merge(['phone' => $phone]);

            $this->validate($request, [
                'phone' => 'size:11'
            ], [
                'phone.size' => 'Phone number is invalid.'
            ]);
        }


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

        $request = $this->parseAddress($request);
        $dataToUpdate = $request->except(['redirect_after_save', 'password']);


        //encrypt password
        if ($request->input('password')) {
            $dataToUpdate['password'] = bcrypt($request->input('password'));
        }


        if($request->input('phone_format')){
            $phone = preg_replace('/[^0-9]/', '', trim($request->input('phone_format')));
            if(strlen($phone) == 10){
                $phone = '1' . $phone;
            }

            $request->merge(['phone' => $phone]);
            $dataToUpdate['phone'] = $phone;

            $this->validate($request, [
                'phone' => 'size:11'
            ], [
                'phone.size' => 'Phone number is invalid.'
            ]);
        }



        // update the row in the db
        $this->crud->update(\Request::get($this->crud->model->getKeyName()), $dataToUpdate);

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->setSaveAction();

        return $this->performSaveAction();
    }

    protected function parseAddress($request)
    {
        switch($request->input('address_country')){
            case 'US':
                $request->merge([
                    'address_state' => $request->input('address_state_us'),
                    'address_zip' => $request->input('address_zip_us')
                ]);
                break;

            case 'CA':
                $request->merge([
                    'address_state' => $request->input('address_state_ca'),
                    'address_zip' => $request->input('address_zip_ca')
                ]);
                break;
        }

        return $request;
    }
}
