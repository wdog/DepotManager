<?php
Route::get( '/', function () {
    return redirect( '/admin/home' );
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

Route::group( [ 'middleware' => [ 'auth' ], 'prefix' => 'admin', 'as' => 'admin.' ], function () {

    Route::get( '/home', 'HomeController@index' );
    Route::resource( 'abilities', 'Admin\AbilitiesController' );
    Route::post( 'abilities_mass_destroy', [ 'uses' => 'Admin\AbilitiesController@massDestroy', 'as' => 'abilities.mass_destroy' ] );

    Route::resource( 'roles', 'Admin\RolesController' );
    Route::post( 'roles_mass_destroy', [ 'uses' => 'Admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy' ] );

    Route::resource( 'groups', 'Admin\GroupsController' );

    Route::resource( 'users', 'Admin\UsersController' );
    Route::post( 'users_mass_destroy', [ 'uses' => 'Admin\UsersController@massDestroy', 'as' => 'users.mass_destroy' ] );

} );

// Depots
Route::group( [ 'middleware' => [ 'auth' ], ], function () {
    // Add Items to Depot
    Route::get( 'depots/{depot}/item/add', [ 'uses' => 'DepotController@addItem', 'as' => 'depots.add_item' ] );
    Route::post( 'depots/{depot}/item', [ 'uses' => 'DepotController@storeItem', 'as' => 'depots.store_item' ] );


    // unload item from depot
    Route::get( 'depots/{depot}/item/{item}/unload', [ 'uses' => 'DepotController@unloadItem', 'as' => 'depots.unload_item' ] );
    Route::post( 'depots/{depot}/item/{item}/unload', [ 'uses' => 'DepotController@createMovementItem', 'as' => 'depots.movement_item' ] );
    Route::resource( 'depots', 'DepotController' );

} );

// Items
Route::group( [ 'middleware' => [ 'auth' ] ], function () {
    Route::resource( 'items', 'ItemController' );
} );