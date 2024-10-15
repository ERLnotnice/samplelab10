<?php

require "vendor/autoload.php";
require "init.php";

// Database connection object (from init.php (DatabaseConnection))
global $conn;

try {

    // Create Router instance
    $router = new \Bramus\Router\Router();

    // Define routes
     $router->get('/', '\App\Controllers\HomeController@index');
    // $router->get('/suppliers', '\App\Controllers\SupplierController@list');
    // $router->get('/suppliers/{id}', '\App\Controllers\SupplierController@single');
    // $router->post('/suppliers/{id}', '\App\Controllers\SupplierController@update');

    $router->get('/login', '\App\Controllers\LoginController@showLoginForm');
    $router->post('/login', '\App\Controllers\LoginController@login');
    $router->get('/logout', '\App\Controllers\LoginController@logout');

    $router->get('/registrations', '\App\Controllers\RegistrationController@list');         // List all registered users
    $router->get('/single-registration', '\App\Controllers\RegistrationController@create');            // Show the registration form
    $router->get('/single-registration/{id}', '\App\Controllers\RegistrationController@single');       // View a single user's registration details
    $router->post('/register', '\App\Controllers\RegistrationController@store');            // Handle registration form submission
    $router->post('/register/{id}', '\App\Controllers\RegistrationController@update');      // Handle updating user details
    // Run it!


    // Define routes
$router->get('/', '\App\Controllers\HomeController@index'); // Home page
$router->get('/home', '\App\Controllers\HomeController@index'); // Alternative home route

// Registration routes
$router->get('/register', '\App\Controllers\RegistrationController@create'); // Show registration form
$router->post('/register', '\App\Controllers\RegistrationController@store'); // Handle registration submission

// Login routes
$router->get('/login', '\App\Controllers\LoginController@showLoginForm'); // Show login form
$router->post('/login', '\App\Controllers\LoginController@login'); // Handle login submission
$router->get('/logout', '\App\Controllers\LoginController@logout'); // Handle logout

// User dashboard (you can modify based on your application)
$router->get('/dashboard', '\App\Controllers\DashboardController@index'); // Show user dashboard

// Additional routes for user management (optional)
$router->get('/profile', '\App\Controllers\UserController@profile'); // User profile page
$router->post('/profile/update', '\App\Controllers\UserController@update'); // Update user profile information

    $router->run();

} catch (Exception $e) {

    echo json_encode([
        'error' => $e->getMessage()
    ]);

}
