<?php
    require_once 'libs/router.php';
    require_once 'app\controllers\noticiasController.php';
    require_once 'app/controllers/user.api.controller.php';
    require_once 'app/middlewares/jwt.auth.middleware.php';

    $router = new Router();
    $router->addMiddleware(new JWTAuthMiddleware());
    #                 endpoint        verbo            controller              metodo
    #GET
    $router->addRoute('noticias',        'GET',          'NoticiasApiController', 'getAll');
    $router->addRoute('noticias/:id',    'GET',          'NoticiasApiController', 'getById');


    #POST
    $router->addRoute('noticias',        'POST',         'NoticiasApiController', 'create');

    #PUT 
    $router->addRoute('noticias/:id',    'PUT',           'NoticiasApiController', 'update');

    #DELETE
    $router->addRoute('noticias/:id',     'DELETE',       'NoticiasApiController',  'eliminar');

    $router->addRoute('usuarios/token'    ,            'GET',     'UserApiController',   'getToken');


    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
