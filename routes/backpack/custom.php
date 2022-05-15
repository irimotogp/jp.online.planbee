<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
    'as' => 'admin.'
], function () { // custom admin routes
    // CRUD resources and other admin routes
    Route::group(['middleware' => ['role:super']], function () {
        Route::crud('agency', 'AgencyCrudController');
        Route::crud('customer', 'CustomerCrudController');
        Route::crud('introducer', 'IntroducerCrudController');
        Route::crud('product', 'ProductCrudController');
        Route::crud('deposit', 'DepositCrudController');
        Route::crud('privacy', 'PrivacyCrudController');
    });
}); // this should be the absolute last line of this file