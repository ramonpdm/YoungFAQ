<?php

namespace App\Core;

class Routes
{
    public static function getRoutes()
    {
        return [
            //            'GET /' => ['controller'=>'IndexController', 'action'=> 'index'],
            //            'POST /login' =>['controller'=>'AuthController','action'=>'login']
            //            'GET /register' =>[
            //                'controller'=>'RegisterController',
            //                    ],
            //            'GET /logout' =>  ['controller'=>'LogoutController',],
            //            'GET /user/profile/{id}'=>['controller'=>'UserController','action'=>'showProfile'],
            //            'GET /admin/users' =>   ['controller'=>'AdminController',    'action'=>'getUsersList'],
            //            'GET /user/profile/{id}'=>['controller'=>'UserController','action'=>'showProfile'],
            //            'GET /users/list' =>   ['controller'=>'UserController',    'action'=>'listUsers'],
            //            'GET /user/profile/{id}'=>['controller'=>'UserController','action'=>'showProfile'],
            //            'GET /users/create' =>   ['controller'=>'UsersController@getCreateForm'],
            //            'POST /users/' =>    ['controller'=>'UsersController@postStoreUser'],
            //            'GET /users/{id}/edit' =>     ['controller'=>'UsersController@getUserEditPage', 'params'=>['id']],
            //            'GET /posts/{id}' =>     ['controller'=>'PostsController@showPostById'],
            //            'GET /posts/create' =>      ['controller'=>'PostsController@getPostCreateForm'],
            //            'GET /posts/create' =>      ['controller'=>'PostsController@getPostCreateForm'],
            //            'GET /posts' =>      ['controller'=>'PostsController@getAllPosts'],
            //            'GET /posts/create' =>       ['controller'=>'PostsController@getPostCreateForm'],
            //            'GET /posts/create' =>       ['controller'=>'PostsController@getPostCreatePage'],
            //            'GET /posts' =>          ['controller'=>'PostsController@getAllPosts'],
            //            'GET /posts' =>              ['controller'=>'PostsController@getAllPosts'],
            //            'GET /posts/{id}/edit' =>         ['controller'=>'PostsController@getPostEditPage'],
            //            'GET /posts' =>                  ['controller'=>'PostsController@getAllPosts'],
            //            'GET /posts' =>                      ['controller'=>'PostsController@getAllPosts'],
            //            'GET /posts' =>                      ['controller'=>'PostsController@getAllPosts'],
            //            'GET /posts' =>                      ['controller'=>'PostsController@getAllPosts'],
            //            'GET /posts' =>                      ['controller'=>'PostsController@getAllPosts'],

        ];
    }

    public static function init($namespace)
    {
        // Verificar si existe el parámetro del controlador
        if (isset($_GET['route']) && !empty($_GET['route'])) {

            // Primera letra mayúscula
            $route =  ucfirst($_GET['route']);

            // Convertir de plural a singular
            $controller =  (substr($route, -1) === 's' ? substr($route, 0, -1) : $route);

            // Retornar el nombre del controlador
            // que manejará esta ruta
            if (class_exists($namespace . $controller))
                return $namespace . $controller;
        }
    }
}
