<?php

// POINT D'ENTRÉE UNIQUE :
// FrontController

// inclusion des dépendances via Composer
// autoload.php permet de charger d'un coup toutes les dépendances installées avec composer
// mais aussi d'activer le chargement automatique des classes (convention PSR-4)
require_once '../vendor/autoload.php';

session_start();

//dump($_SESSION);

/* ------------
--- ROUTAGE ---
-------------*/


// création de l'objet router
// Cet objet va gérer les routes pour nous, et surtout il va
$router = new AltoRouter();

// le répertoire (après le nom de domaine) dans lequel on travaille est celui-ci
// Mais on pourrait travailler sans sous-répertoire
// Si il y a un sous-répertoire
if (array_key_exists('BASE_URI', $_SERVER)) {
    // Alors on définit le basePath d'AltoRouter
    $router->setBasePath($_SERVER['BASE_URI']);
// ainsi, nos routes correspondront à l'URL, après la suite de sous-répertoire
}
// sinon
else {
    // On donne une valeur par défaut à $_SERVER['BASE_URI'] car c'est utilisé dans le CoreController
    $_SERVER['BASE_URI'] = '/';
}

// On doit déclarer toutes les "routes" à AltoRouter, afin qu'il puisse nous donner LA "route" correspondante à l'URL courante
// On appelle cela "mapper" les routes
// 1. méthode HTTP : GET ou POST (pour résumer)
// 2. La route : la portion d'URL après le basePath
// 3. Target/Cible : informations contenant
//      - le nom de la méthode à utiliser pour répondre à cette route
//      - le nom du controller contenant la méthode
// 4. Le nom de la route : pour identifier la route, on va suivre une convention
//      - "NomDuController-NomDeLaMéthode"
//      - ainsi pour la route /, méthode "home" du MainController => "main-home"
$router->map(
    'GET',
    '/',
    [
        'method' => 'home',
        'controller' => 'MainController'
    ],
    'main-home'
);
$router->map(
    'GET',
    '/category/list',
    [
        'method' => 'list',
        'controller' => 'CategoryController'
    ],
    'category-list'
);
$router->map(
    'GET',
    '/category/add',
    [
        'method' => 'add',
        'controller' => 'CategoryController'
    ],
    'category-add'
);
$router->map(
    'POST',
    '/category/add',
    [
        'method' => 'createEdit',
        'controller' => 'CategoryController'
    ],
    'category-add-post'
);
$router->map(
    'GET',
    '/category/update/[i:idCategory]',
    [
        'method' => 'update',
        'controller' => 'CategoryController'
    ],
    'category-update'
);
$router->map(
    'POST',
    '/category/update/[i:idCategory]',
    [
        'method' => 'createEdit',
        'controller' => 'CategoryController'
    ],
    'category-update-post'
);
$router->map(
    'GET',
    '/category/home/update',
    [
        'method' => 'updateHome',
        'controller' => 'CategoryController'
    ],
    'category-update-home'
);
$router->map(
    'POST',
    '/category/home/update',
    [
        'method' => 'editHome',
        'controller' => 'CategoryController'
    ],
    'category-update-home-post'
);
$router->map(
    'GET',
    '/category/delete/[i:idCategory]',
    [
        'method' => 'delete',
        'controller' => 'CategoryController'
    ],
    'category-delete'
);
$router->map(
    'GET',
    '/product/list',
    [
        'method' => 'list',
        'controller' => 'ProductController'
    ],
    'product-list'
);
$router->map(
    'GET',
    '/product/add',
    [
        'method' => 'add',
        'controller' => 'ProductController'
    ],
    'product-add'
);
$router->map(
    'POST',
    '/product/add',
    [
        'method' => 'createEdit',
        'controller' => 'ProductController'
    ],
    'product-add-post'
);
$router->map(
    'GET',
    '/product/update/[i:idProduct]',
    [
        'method' => 'update',
        'controller' => 'ProductController'
    ],
    'product-update'
);
$router->map(
    'POST',
    '/product/update/[i:idProduct]',
    [
        'method' => 'createEdit',
        'controller' => 'ProductController'
    ],
    'product-update-post'
);
$router->map(
    'GET',
    '/product/delete/[i:idProduct]',
    [
        'method' => 'delete',
        'controller' => 'ProductController'
    ],
    'product-delete'
);
$router->map(
    'GET',
    '/type/list',
    [
        'method' => 'list',
        'controller' => 'TypeController'
    ],
    'type-list'
);
$router->map(
    'GET',
    '/type/add',
    [
        'method' => 'add',
        'controller' => 'TypeController'
    ],
    'type-add'
);
$router->map(
    'POST',
    '/type/add',
    [
        'method' => 'createEdit',
        'controller' => 'TypeController'
    ]
    ,'type-add-post'
);
$router->map(
    'GET',
    '/type/update/[i:idType]',
    [
        'method' => 'update',
        'controller' => 'TypeController'
    ],
    'type-update'
);
$router->map(
    'POST',
    '/type/update/[i:idType]',
    [
        'method' => 'createEdit',
        'controller' => 'TypeController'
    ],
    'type-update-post'
);
$router->map(
    'GET',
    '/type/delete/[i:idType]',
    [
        'method' => 'delete',
        'controller' => 'TypeController'
    ],
    'type-delete'
);
$router->map(
    'GET',
    '/brand/list',
    [
        'method' => 'list',
        'controller' => 'BrandController'
    ],
    'brand-list'
);
$router->map(
    'GET',
    '/brand/add',
    [
        'method' => 'add',
        'controller' => 'BrandController'
    ],
    'brand-add'
);
$router->map(
    'POST',
    '/brand/add',
    [
        'method' => 'createEdit',
        'controller' => 'BrandController'
    ],
    'brand-add-post'
);
$router->map(
    'GET',
    '/brand/update/[i:idBrand]',
    [
        'method' => 'update',
        'controller' => 'BrandController'
    ],
    'brand-update'
);
$router->map(
    'POST',
    '/brand/update/[i:idBrand]',
    [
        'method' => 'createEdit',
        'controller' => 'BrandController'
    ],
    'brand-update-post'
);
$router->map(
    'GET',
    '/brand/delete/[i:idBrand]',
    [
        'method' => 'delete',
        'controller' => 'BrandController'
    ],
    'brand-delete'
);
$router->map(
    'GET',
    '/login',
    [
        'method' => 'login',
        'controller' => 'UserController'
    ],
    'user-login'
);
$router->map(
    'POST',
    '/login',
    [
        'method' => 'checkLogin',
        'controller' => 'UserController'
    ],
    'user-login-post'
);
$router->map(
    'GET',
    '/logout',
    [
        'method' => 'logout',
        'controller' => 'UserController'
    ],
    'user-logout'
);
$router->map(
    'GET',
    '/user/list',
    [
        'method' => 'list',
        'controller' => 'UserController'
    ],
    'user-list'
);
$router->map(
    'GET',
    '/user/add',
    [
        'method' => 'add',
        'controller' => 'UserController'
    ],
    'user-add'
);
$router->map(
    'POST',
    '/user/add',
    [
        'method' => 'createEdit',
        'controller' => 'UserController'
    ],
    'user-add-post'
);
$router->map(
    'GET',
    '/user/update/[i:idUser]',
    [
        'method' => 'update',
        'controller' => 'UserController'
    ],
    'user-update'
);
$router->map(
    'POST',
    '/user/update/[i:idUser]',
    [
        'method' => 'createEdit',
        'controller' => 'UserController'
    ],
    'user-update-post'
);
$router->map(
    'GET',
    '/user/delete/[i:idUser]',
    [
        'method' => 'delete',
        'controller' => 'UserController'
    ],
    'user-delete'
);
/* -------------
--- DISPATCH ---
--------------*/

// On demande à AltoRouter de trouver une route qui correspond à l'URL courante
$match = $router->match();

// Ensuite, pour dispatcher le code dans la bonne méthode, du bon Controller
// On délègue à une librairie externe : https://packagist.org/packages/benoclock/alto-dispatcher
// 1er argument : la variable $match retournée par AltoRouter
// 2e argument : le "target" (controller & méthode) pour afficher la page 404
$dispatcher = new Dispatcher($match, '\App\Controllers\ErrorController::err404');

$dispatcher->setControllersNamespace('\\App\\Controllers\\');
// Une fois le "dispatcher" configuré, on lance le dispatch qui va exécuter la méthode du controller
$dispatcher->dispatch();