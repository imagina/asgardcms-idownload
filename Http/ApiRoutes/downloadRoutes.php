<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'downloads'], function (Router $router) {
  //Route create
  $router->post('/', [
    'as' => 'api.idownload.download.create',
    'uses' => 'DownloadApiController@create',
    'middleware' => ['auth:api']
  ]);

  //Route index
  $router->get('/', [
    'as' => 'api.idownload.download.get.items.by',
    'uses' => 'DownloadApiController@index',
    //'middleware' => ['auth:api']
  ]);

  //Route send subscription
  $router->put('/send-subscription/{criteria}', [
    'as' => 'api.idownload.download.sendSubscription',
    'uses' => 'DownloadApiController@sendSubscription',
    //'middleware' => ['auth:api']
  ]);

  //Route show
  $router->get('/{criteria}', [
    'as' => 'api.idownload.download.get.item',
    'uses' => 'DownloadApiController@show',
    //'middleware' => ['auth:api']
  ]);

  //Route update
  $router->put('/{criteria}', [
    'as' => 'api.idownload.download.update',
    'uses' => 'DownloadApiController@update',
    'middleware' => ['auth:api']
  ]);

  //Route delete
  $router->delete('/{criteria}', [
    'as' => 'api.idownload.download.delete',
    'uses' => 'DownloadApiController@delete',
    'middleware' => ['auth:api']
  ]);

});
