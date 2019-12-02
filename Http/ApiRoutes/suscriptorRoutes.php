<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'suscriptors'], function (Router $router) {

  //Route create
  $router->post('/', [
    'as' => 'api.idownload.suscriptor.create',
    'uses' => 'SuscriptorApiController@create',
    'middleware' => ['auth:api']
  ]);

  //Route index
  $router->get('/', [
    'as' => 'api.idownload.suscriptor.get.items.by',
    'uses' => 'SuscriptorApiController@index',
    //'middleware' => ['auth:api']
  ]);

  //Route show
  $router->get('/{criteria}', [
    'as' => 'api.idownload.suscriptor.get.item',
    'uses' => 'SuscriptorApiController@show',
    //'middleware' => ['auth:api']
  ]);

  //Route update
  $router->put('/{criteria}', [
    'as' => 'api.idownload.suscriptor.update',
    'uses' => 'SuscriptorApiController@update',
    'middleware' => ['auth:api']
  ]);

  //Route delete
  $router->delete('/{criteria}', [
    'as' => 'api.idownload.suscriptor.delete',
    'uses' => 'SuscriptorApiController@delete',
    'middleware' => ['auth:api']
  ]);
});
