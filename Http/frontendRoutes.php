<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/downloads'], function (Router $router) {
    $router->bind('downloadSlug', function ($slug) {
      return app('Modules\Idownload\Repositories\DownloadRepository')->whereSlug($slug);
    });
    $router->bind('categorySlug', function ($slug) {
      return app('Modules\Idownload\Repositories\CategoryRepository')->whereSlug($slug);
    });
    $locale = LaravelLocalization::setLocale() ?: App::getLocale();
    $router->get('/', [
        'as' => 'frontend.idownload.index',
        'uses' => 'PublicController@index',
        //'middleware' => 'can:idownload.categories.index'
    ]);
    $router->get('search', [
        'as' =>  'frontend.idownload.search',
        'uses' => 'PublicController@index'
    ]);
    $router->get('{categorySlug}', [
        'as' =>  $locale.'.idownload.category',
        'uses' => 'PublicController@category'
    ]);

    $router->get('{categorySlug}/{downloadSlug}', [
        'as' =>  $locale.'.idownload.download',
        'uses' => 'PublicController@show'
    ]);

    $router->put('{download}/send', [
      'as' =>  $locale.'.idownload.send',
      'uses' => 'PublicController@sendSubscription'
    ]);


});
