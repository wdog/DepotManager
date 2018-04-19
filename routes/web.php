<?php

use App\Mail\NotifyUnload;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;

Route::get( '/', function () {
    return redirect( '/home' );
} );

// Authentication Routes...
$this->get( 'login', 'Auth\LoginController@showLoginForm' )->name( 'auth.login' );
$this->post( 'login', 'Auth\LoginController@login' )->name( 'auth.login' );
$this->post( 'logout', 'Auth\LoginController@logout' )->name( 'auth.logout' );

// Change Password Routes...
$this->get( 'change_password', 'Auth\ChangePasswordController@showChangePasswordForm' )->name( 'auth.change_password' );
$this->patch( 'change_password', 'Auth\ChangePasswordController@changePassword' )->name( 'auth.change_password' );

// Password Reset Routes...
$this->get( 'password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm' )->name( 'auth.password.reset' );
$this->post( 'password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail' )->name( 'auth.password.reset' );
$this->get( 'password/reset/{token}', 'Auth\ResetPasswordController@showResetForm' )->name( 'password.reset' );
$this->post( 'password/reset', 'Auth\ResetPasswordController@reset' )->name( 'auth.password.reset' );


//******************ADMIN APP ROUTES**************************//
Route::group( [ 'middleware' => [ 'auth' ], 'prefix' => 'admin', 'as' => 'admin.' ], function () {

    Route::resource( 'abilities', 'Admin\AbilitiesController' );
    Route::resource( 'roles', 'Admin\RolesController' );
    Route::resource( 'groups', 'Admin\GroupsController' );
    Route::resource( 'users', 'Admin\UsersController' );

} );

//******************MAIN APP ROUTES**************************//
Route::group( [ 'middleware' => [ 'auth' ], ], function () {
    Route::get( '/home', [ 'uses' => 'HomeController@index', 'as' => 'home' ] );


    // Language
    Route::get( 'lang/{locale}', 'HomeController@switchLocale' );
    // Add Items to Depot
    Route::get( 'depots/{depot}/item/add', [ 'uses' => 'DepotController@addItem', 'as' => 'depots.add_item' ] );
    Route::post( 'depots/{depot}/item', [ 'uses' => 'DepotController@storeItem', 'as' => 'depots.store_item' ] );

    // unload item from depot
    Route::get( 'depots/{depot}/item/{item}/unload', [ 'uses' => 'DepotController@unloadItem', 'as' => 'depots.unload_item' ] );
    Route::post( 'depots/{depot}/item/{item}/unload', [ 'uses' => 'DepotController@createMovementItem', 'as' => 'depots.movement_item' ] );
    // manage depots
    Route::resource( 'depots', 'DepotController' );

    // manage items
    Route::get( 'items/{item}/project', [ 'uses' => 'ItemController@projects', 'as' => 'items.project' ] );

    Route::resource( 'items', 'ItemController' );
    // manage project
    // Add Items to Depot
    Route::get( 'projects/{project}/item/add', [ 'uses' => 'ProjectController@addItem', 'as' => 'projects.add_item' ] );
    Route::post( 'projects/{project}/add_missing', [ 'uses' => 'ProjectController@addMissing', 'as' => 'projects.add_missing' ] );
    Route::post( 'projects/{project}/item', [ 'uses' => 'ProjectController@storeItem', 'as' => 'projects.store_item' ] );
    Route::resource( 'projects', 'ProjectController' );
} );


Route::get( '/mail', function () {
    return new NotifyUnload( \App\Movement::find( 28 ) );
    dd( "Mail Send Successfully" );
} );
