<?php
// turn on error reporting
ini_set('display_error', 1);
error_reporting(E_ALL);

// session
session_start();

// require the autoload file
require_once('vendor/autoload.php');
require_once('model/data-layer.php');
require_once('model/validation.php');

// create an instance of the base class
$f3 = Base::instance();

// Define a default route
$f3->route('GET /' , function(){
    // fat free - taking the view page and rendering it in the browser
    $view = new Template();
    echo $view->render('views/home.html');
});

// Dating -- Create Account -- Personal Information
$f3->route('GET|POST /create1' , function($f3){
    // fat free - taking the view page and rendering it in the browser
    var_dump($_POST);

    // sticky
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(validName($_POST['fname'])) {
            $_SESSION['fname'] = $_POST['fname'];
        } else {
            $f3->set('errors["fname"]', "First name required"); // if data is not valid set error message in HIVE
        } // first name

        if(validName($_POST['lname'])) {
            $_SESSION['lname'] = $_POST['lname'];
        } else {
            $f3->set('errors["lname"]', "Last name required");
        } // last name

        if(validAge($_POST['age'])) {
            $_SESSION['age'] = $_POST['age'];
        } else {
            $f3->set('errors["age"]', "Age required - Must be 18+");
        } // age

        if(isset($_POST['gender'])){
            $_SESSION['gender'] = $_POST['gender'];
        } //gender

        if(validPhone($_POST['phonenumber'])) {
            $_SESSION['phonenumber'] = $_POST['phonenumber'];
        } else{
            $f3->set('errors["phonenumber"]', "Phone must be 000-000-0000 format");
        } // phone number

        // if no errors - > redirect to following sign up page -> create2
        if(empty($f3->get('errors'))){
            $f3->reroute('/create2');
        }
    }

    $view = new Template();
    echo $view->render('views/create1.html');
});

// Dating -- Create Account -- Profile
$f3->route('GET|POST /create2' , function(){
    // fat free - taking the view page and rendering it in the browser
    //var_dump($_POST);







    $view = new Template();
    echo $view->render('views/create2.html');
});

// Dating -- Create Account -- Interests
$f3->route('POST /create3' , function($f3){
    //var_dump($_POST);

    if(isset($_POST['email'])){
        $_SESSION['email'] = $_POST['email'];
    }

    if(isset($_POST['state'])){
        $_SESSION['state'] = $_POST['state'];
    }

    if(isset($_POST['seeking'])){
        $_SESSION['seeking'] = $_POST['seeking'];
    }

    if(isset($_POST['biography'])){
        $_SESSION['biography'] = $_POST['biography'];
    }

    // fat free - taking the view page and rendering it in the browser
    // HIVE
    $f3->set('indoor', getIndoorInterests());
    $f3->set('outdoor', getOutdoorInterests());
    $view = new Template();
    echo $view->render('views/create3.html');
});

// Dating -- Create Account -- Summary
$f3->route('POST /summary' , function(){
    // fat free - taking the view page and rendering it in the browser

    //var_dump($_SESSION);

    if(isset($_POST['interests'])){
        $_SESSION['interests'] = implode(", ",$_POST['interests']);
    }

    $view = new Template();
    echo $view->render('views/summary.html');

    session_destroy();
});

// Run fat free
$f3->run();