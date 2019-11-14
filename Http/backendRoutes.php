<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/idownload'], function (Router $router) {
    $router->bind('idownloadCategory', function ($id) {
        return app('Modules\Idownload\Repositories\CategoryRepository')->find($id);
    });
    $router->get('categories', [
        'as' => 'admin.idownload.category.index',
        'uses' => 'CategoryController@index',
        'middleware' => 'can:idownload.categories.index'
    ]);
    $router->get('categories/create', [
        'as' => 'admin.idownload.category.create',
        'uses' => 'CategoryController@create',
        'middleware' => 'can:idownload.categories.create'
    ]);
    $router->post('categories', [
        'as' => 'admin.idownload.category.store',
        'uses' => 'CategoryController@store',
        'middleware' => 'can:idownload.categories.create'
    ]);
    $router->get('categories/{idownloadCategory}/edit', [
        'as' => 'admin.idownload.category.edit',
        'uses' => 'CategoryController@edit',
        'middleware' => 'can:idownload.categories.edit'
    ]);
    $router->put('categories/{idownloadCategory}', [
        'as' => 'admin.idownload.category.update',
        'uses' => 'CategoryController@update',
        'middleware' => 'can:idownload.categories.edit'
    ]);
    $router->delete('categories/{idownloadCategory}', [
        'as' => 'admin.idownload.category.destroy',
        'uses' => 'CategoryController@destroy',
        'middleware' => 'can:idownload.categories.destroy'
    ]);
    $router->bind('download', function ($id) {
        return app('Modules\Idownload\Repositories\DownloadRepository')->find($id);
    });
    $router->get('downloads', [
        'as' => 'admin.idownload.download.index',
        'uses' => 'DownloadController@index',
        'middleware' => 'can:idownload.downloads.index'
    ]);
    $router->get('downloads/create', [
        'as' => 'admin.idownload.download.create',
        'uses' => 'DownloadController@create',
        'middleware' => 'can:idownload.downloads.create'
    ]);
    $router->post('downloads', [
        'as' => 'admin.idownload.download.store',
        'uses' => 'DownloadController@store',
        'middleware' => 'can:idownload.downloads.create'
    ]);
    $router->get('downloads/{download}/edit', [
        'as' => 'admin.idownload.download.edit',
        'uses' => 'DownloadController@edit',
        'middleware' => 'can:idownload.downloads.edit'
    ]);
    $router->put('downloads/{download}', [
        'as' => 'admin.idownload.download.update',
        'uses' => 'DownloadController@update',
        'middleware' => 'can:idownload.downloads.edit'
    ]);
    $router->delete('downloads/{download}', [
        'as' => 'admin.idownload.download.destroy',
        'uses' => 'DownloadController@destroy',
        'middleware' => 'can:idownload.downloads.destroy'
    ]);
    $router->bind('suscriptor', function ($id) {
        return app('Modules\Idownload\Repositories\SuscriptorRepository')->find($id);
    });
    $router->get('suscriptors', [
        'as' => 'admin.idownload.suscriptor.index',
        'uses' => 'SuscriptorController@index',
        'middleware' => 'can:idownload.suscriptors.index'
    ]);
    $router->get('suscriptors/create', [
        'as' => 'admin.idownload.suscriptor.create',
        'uses' => 'SuscriptorController@create',
        'middleware' => 'can:idownload.suscriptors.create'
    ]);
    $router->post('suscriptors', [
        'as' => 'admin.idownload.suscriptor.store',
        'uses' => 'SuscriptorController@store',
        'middleware' => 'can:idownload.suscriptors.create'
    ]);
    $router->get('suscriptors/{suscriptor}/edit', [
        'as' => 'admin.idownload.suscriptor.edit',
        'uses' => 'SuscriptorController@edit',
        'middleware' => 'can:idownload.suscriptors.edit'
    ]);
    $router->put('suscriptors/{suscriptor}', [
        'as' => 'admin.idownload.suscriptor.update',
        'uses' => 'SuscriptorController@update',
        'middleware' => 'can:idownload.suscriptors.edit'
    ]);
    $router->delete('suscriptors/{suscriptor}', [
        'as' => 'admin.idownload.suscriptor.destroy',
        'uses' => 'SuscriptorController@destroy',
        'middleware' => 'can:idownload.suscriptors.destroy'
    ]);
// append



});
