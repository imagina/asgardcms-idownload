<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'idownload/v1'], function (Router $router) {

  //======  CATEGORIES
  require('ApiRoutes/categoryRoutes.php');

  //======  POSTS
  require('ApiRoutes/downloadRoutes.php');

  //======  Suscriptors
  require('ApiRoutes/suscriptorRoutes.php');

});

