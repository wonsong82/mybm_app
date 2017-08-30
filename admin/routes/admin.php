<?php


// Admin Main Route
Route::get('/', 'AdminController@redirect')->name('admin');
Route::get('dashboard', 'AdminController@dashboard');


// Users
CRUD::resource('permission', 'PermissionCrudController');
CRUD::resource('role', 'RoleCrudController');
CRUD::resource('user', 'UserCrudController');


// User Profile
CRUD::resource('profile', 'UserProfileCrudController');

// Phonebooks
CRUD::resource('phonebook', 'PhonebookCrudController');

// Addressbooks
CRUD::resource('addressbook', 'AddressbookCrudController');


// Soon Application
Route::get('soon-application/status/{term}', 'SoonApplicationCrudController@status');
CRUD::resource('soon-application', 'SoonApplicationCrudController');
