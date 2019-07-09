<?php
/*
|--------------------------------------------------------------------------
| Newpixel\PartnerCRUD Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the Newpixel\PartnerCRUD package.
|
*/
Route::group([
    'namespace' => 'Newpixel\PartnerCRUD\app\Http\Controllers\Admin',
        'prefix' => config('backpack.base.route_prefix', 'admin'),
        'middleware' => ['web', backpack_middleware()],
    ], function () {
        CRUD::resource('partner', 'PartnerCRUDController');
    });
