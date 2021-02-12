<?php
// turn on error reporting
ini_set('display_error', 1);
error_reporting(E_ALL);

// require the autoload file
require_once('vendor/autoload.php');
require_once('model/data-layer.php');

// create an instance of the base class
$f3 = Base::instance();

// Define a default route
$f3->route('GET /' , function(){
    // fat free - taking the view page and rendering it in the browser
    $view = new Template();
    echo $view->render('views/home.html');
});

// Dating -- Create Account -- Personal Information
$f3->route('GET /create1' , function(){
    // fat free - taking the view page and rendering it in the browser
    $view = new Template();
    echo $view->render('views/create1.html');
});

// Dating -- Create Account -- Profile
$f3->route('POST /create2' , function(){
    // fat free - taking the view page and rendering it in the browser
    $view = new Template();
    echo $view->render('views/create2.html');
});

// Dating -- Create Account -- Interests
$f3->route('POST /create3' , function($f3){
    // fat free - taking the view page and rendering it in the browser
    // HIVE
    $f3->set('indoor', getIndoorInterests());
    $f3->set('outdoor', getOutdoorInterests());
    $view = new Template();
    echo $view->render('views/create3.html');
});

// Run fat free
$f3->run();