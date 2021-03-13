<?php
// turn on error reporting
ini_set('display_error', 1);
error_reporting(E_ALL);

// require the autoload file
require_once('vendor/autoload.php');
require $_SERVER['DOCUMENT_ROOT'].'/../config.php';

// session
session_start();

// create an instance of the base class
$f3 = Base::instance();
$controller = new Controller($f3);
$dataLayer = new DataLayer();
$validator = new Validate();


// Define a default route
$f3->route('GET /' , function(){
    global $controller;
    $controller->home();
});

// Dating -- Create Account -- Personal Information
$f3->route('GET|POST /create1' , function($f3){
    global $controller;
    $controller->create1($f3);
});

// Dating -- Create Account -- Profile
$f3->route('GET|POST /create2' , function($f3){
    global $controller;
    $controller->create2($f3);
});

// Dating -- Create Account -- Interests
$f3->route('GET|POST /create3' , function($f3){
    global $controller;
    $controller->create3($f3);
});

// Dating -- Create Account -- Summary
$f3->route('GET|POST /summary' , function(){
    global $controller;
    $controller->summary();
});

// Run fat free
$f3->run();