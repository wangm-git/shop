<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

    $router->resource('test', TestController::class);
    $router->resource('category', CategoryController::class);
    $router->resource('product', ProductController::class);
    $router->resource('group-product', GroupProductController::class);
    $router->resource('seckill-product', SeckillProductController::class);
	$router->resource('spec', SpecController::class);
	$router->resource('coupon', CouponController::class);

});
