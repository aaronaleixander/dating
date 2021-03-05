<?php
// turn on error reporting
ini_set('display_error', 1);
error_reporting(E_ALL);

// require the autoload file
require_once('vendor/autoload.php');
require_once('model/data-layer.php');
require_once('model/validation.php');

// session
session_start();

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

    // sticky
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        // POST ARRAY DATA
        $userFname = trim($_POST['fname']);
        $userLname = trim($_POST['lname']);
        $userAge = trim($_POST['age']);
        $userPhone = trim($_POST['phonenumber']);
        // TODO: check if user wants to be a premium account (if(isset post checkbox))
        $isPremium = $_POST['premium'];

        if($isPremium == "on") {
            $account = new Premium("", "", "", "", "", true, [], []);
            if (validName($userFname)) {
                //$_SESSION['fname'] = $userFname;
                $account->setFname($userFname);
            } else {
                $f3->set('errors["fname"]', "First name required - Alphabetic Letters Only"); // if data is not valid set error message in HIVE
            } // first name

            if (validName($userLname)) {
                //$_SESSION['lname'] = $userLname;
                $account->setLname($userLname);
            } else {
                $f3->set('errors["lname"]', "Last name required - Alphabetic Letters Only");
            } // last name

            if (validAge($userAge)) {
                //$_SESSION['age'] = $userAge;
                $account->setAge($userAge);
            } else {
                $f3->set('errors["age"]', "Age required - Must be 18+");
            } // age

            if (isset($_POST['gender'])) {
                //$_SESSION['gender'] = $_POST['gender'];
                $account->setGender($_POST['gender']);
            }

            if (validPhone($userPhone)) {
                //$_SESSION['phonenumber'] = $userPhone;
                $account->setPhone($userPhone);
            } else {
                $f3->set('errors["phonenumber"]', "Phone must be 000-000-0000 format");
            } // phone number

            if (empty($f3->get('errors'))) {
                $_SESSION['account'] = $account;
                $f3->reroute('/create2');
            }

        } else {
            $account = new Member("", "", "", "", "", false);

            if (validName($userFname)) {
                $account->setFname($userFname);
            } else {
                $f3->set('errors["fname"]', "First name required - Alphabetic Letters Only"); // if data is not valid set error message in HIVE
            } // first name

            if (validName($userLname)) {
                $account->setLname($userLname);
            } else {
                $f3->set('errors["lname"]', "Last name required - Alphabetic Letters Only");
            } // last name

            if(validAge($userAge)){
                $account->setAge($userAge);
            } else {
                $f3->set('errors["age"]', "Age required - Must be 18+");
            } // age

            if(isset($_POST['gender'])){
                $account->setGender($_POST['gender']);
            } //gender

            if(validPhone($userPhone)){
                $account->setPhone($userPhone);
            } else {
                $f3->set('errors["phonenumber"]', "Phone must be 000-000-0000 format");
            } // phone number

            if (empty($f3->get('errors'))){
                $_SESSION['account'] = $account;
                $f3->reroute('/create2');
            }
        }
    }

    // Sticky Variables
    $f3->set('userFname', isset($userFname) ? $userFname : "");
    $f3->set('userLname', isset($userLname) ? $userLname : "");
    $f3->set('userAge', isset($userAge) ? $userAge : "");
    $f3->set('userPhone', isset($userPhone) ? $userPhone : "");

    $view = new Template();
    echo $view->render('views/create1.html');
});

// Dating -- Create Account -- Profile
$f3->route('GET|POST /create2' , function($f3){

    var_dump($_SESSION['account']);

    $account = $_SESSION['account'];




    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $userEmail = $_POST['email'];
        if (validEmail($userEmail)) {
            $_SESSION['account']->setEmail($userEmail);
        } else {
            $f3->set('errors["email"]', "Email required - @email.com format"); // if data is not valid set error message in HIVE
        } // email

        if(isset($_POST['state'])){
            $_SESSION['account']->setState($_POST['state']);
        }

        if(isset($_POST['seeking'])){
            $_SESSION['account']->setSeeking($_POST['seeking']);
        }

        if(isset($_POST['biography'])){
            $_SESSION['account']->setBio($_POST['biography']);
        }

        // if no errors - > redirect to following sign up page -> create2
        if(empty($f3->get('errors')) && $account->getIsPremium()){
            $f3->reroute('/create3');
        } else {
            $f3->reroute('/summary');
        }
    }

    // Sticky Variables
    $f3->set('userEmail', isset($userEmail) ? $userEmail : "");

    $view = new Template();
    echo $view->render('views/create2.html');
});

// Dating -- Create Account -- Interests
$f3->route('GET|POST /create3' , function($f3){
    //var_dump($_POST);
    // TODO: only premium members fill out interests

    // fat free - taking the view page and rendering it in the browser
    // HIVE
    $f3->set('indoor', getIndoorInterests());
    $f3->set('outdoor', getOutdoorInterests());
    $view = new Template();
    echo $view->render('views/create3.html');
});

// Dating -- Create Account -- Summary
$f3->route('GET|POST /summary' , function(){
    var_dump($_SESSION);
    $account = $_SESSION['account'];
    if(isset($_POST['interests'])){
        $_SESSION['interests'] = implode(", ",$_POST['interests']);
    }

    $view = new Template();
    echo $view->render('views/summary.html');

    session_destroy();
});

// Run fat free
$f3->run();