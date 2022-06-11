<?php

//Require the controller class
// require_once dirname(__DIR__).'/vendor/autoload.php';

error_reporting(E_ALL); // Error/Exception engine, always use E_ALL

ini_set('ignore_repeated_errors', true); // always use TRUE

ini_set('display_errors', false); // Error/Exception display, use FALSE only in production environment or real server. Use TRUE in development environment

ini_set('log_errors', true); // Error/Exception file logging engine.


spl_autoload_register(function ($class) {
    $root = dirname(__DIR__);//get the parent directory
    $file = $root . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_readable($file)) {
        require $file;
    }
});
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');


session_start();

$router=new Core\Router();

//add the routes


$router->add('', "public", ['controller' => 'Home', 'action' => 'index'], );
// $url=$_SERVER['QUERY_STRING'];
// echo ($router->match($url))?var_dump($router->getParams()):"ERROR 404";

// $router->add('signup/{action}', "public", ['controller' => 'Signup']);


$router->add('signup', "public", ['controller' => 'Signup']);
$router->add('signup/{action}', "public", ['controller' => 'Signup']);


$router->add('login', "public", ['controller' => 'Login']);
$router->add('login/{action}', "public", ['controller' => 'Login']);


$router->add('citas', "public", ['controller' => 'Citas']);
$router->add('citas/{action}', "public", ['controller' => 'Citas']);

$router->add('user', "public", ['controller' => 'User']);
$router->add('user/{action}', "public", ['controller' => 'User']);

$router->add('comments', "public", ['controller' => 'Comments']);
$router->add('comments/{action}', "public", ['controller' => 'Comments']);

// $router->add('{controller}/{action}');
// $router->add('{controller}/{action}');
// $router->add('{controller}');

// $router->add('{controller}/{username:[a-zA-Z0-9]+}');
// $router->add('{controller}/{postid:[0-9]+}/{action}');
// $router->add('{controller}/{action}/{id:\d+}');
// $router->add('admin/{username:[a-zA-Z0-9]+}/{controller}/{action}', "", ['namespace'=>'Admin']);
// $router->add('admin/{username:[a-zA-Z0-9]+}/{controller}', "", ['namespace'=>'Admin']);
// $router->add('{controller}/{username:[a-zA-Z0-9]+}', "", ['action'=>'get']);
// $router->add('admin');
$router->dispatch($_SERVER['QUERY_STRING']);
// echo "<pre>";
// var_dump($router->getParams());
// var_dump($router->getRoutes());
// echo "</pre>";
