<?php

class Controller
{
    private $_f3;

    function __construct($f3){
        $this->_f3 = $f3;
    }

    function home(){
        session_destroy();
        // RENDER
        $view = new Template();
        echo $view->render('views/home.html');
    }

    function create1(){
        global $validator;

        // sticky
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // POST ARRAY DATA
            $userFname = trim($_POST['fname']);
            $userLname = trim($_POST['lname']);
            $userAge = trim($_POST['age']);
            $userGender = $_POST['gender'];
            $userPhone = trim($_POST['phonenumber']);
            $isPremium = $_POST['premium'];

            if(isset($isPremium)) {
                $account = new Premium("", "", "", "", "");
                if ($validator->validName($userFname)) {
                    //$_SESSION['fname'] = $userFname;
                    $account->setFname($userFname);
                } else {
                    $this->_f3->set('errors["fname"]', "First name required - Alphabetic Letters Only"); // if data is not valid set error message in HIVE
                } // first name

                if ($validator->validName($userLname)) {
                    //$_SESSION['lname'] = $userLname;
                    $account->setLname($userLname);
                } else {
                    $this->_f3->set('errors["lname"]', "Last name required - Alphabetic Letters Only");
                } // last name

                if ($validator->validAge($userAge)) {
                    //$_SESSION['age'] = $userAge;
                    $account->setAge($userAge);
                } else {
                    $this->_f3->set('errors["age"]', "Age required - Must be 18+");
                } // age

                if (isset($userGender)) {
                    //$_SESSION['gender'] = $_POST['gender'];
                    $account->setGender($userGender);
                }

                if ($validator->validPhone($userPhone)) {
                    //$_SESSION['phonenumber'] = $userPhone;
                    $account->setPhone($userPhone);
                } else {
                    $this->_f3->set('errors["phonenumber"]', "Phone must be 000-000-0000 format");
                } // phone number

                if (empty($this->_f3->get('errors'))) {
                    $_SESSION['account'] = $account;
                    $this->_f3->reroute('/create2');
                }

            } else {
                $account = new Member("", "", "", "", "");

                if ($validator->validName($userFname)) {
                    $account->setFname($userFname);
                } else {
                    $this->_f3->set('errors["fname"]', "First name required - Alphabetic Letters Only"); // if data is not valid set error message in HIVE
                } // first name

                if ($validator->validName($userLname)) {
                    $account->setLname($userLname);
                } else {
                    $this->_f3->set('errors["lname"]', "Last name required - Alphabetic Letters Only");
                } // last name

                if($validator->validAge($userAge)){
                    $account->setAge($userAge);
                } else {
                    $this->_f3->set('errors["age"]', "Age required - Must be 18+");
                } // age

                if(isset($_POST['gender'])){
                    $account->setGender($_POST['gender']);
                } //gender

                if($validator->validPhone($userPhone)){
                    $account->setPhone($userPhone);
                } else {
                    $this->_f3->set('errors["phonenumber"]', "Phone must be 000-000-0000 format");
                } // phone number

                if (empty($this->_f3->get('errors'))){
                    $_SESSION['account'] = $account;
                    $this->_f3->reroute('/create2');
                }
            }
        }

        // Sticky Variables
        $this->_f3->set('userFname', isset($userFname) ? $userFname : "");
        $this->_f3->set('userLname', isset($userLname) ? $userLname : "");
        $this->_f3->set('userAge', isset($userAge) ? $userAge : "");
        $this->_f3->set('userPhone', isset($userPhone) ? $userPhone : "");

        $view = new Template();
        echo $view->render('views/create1.html');
    }

    function create2(){
        global $validator;
        //var_dump($_SESSION['account']);
        $account = $_SESSION['account'];

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userEmail = $_POST['email'];
            if ($validator->validEmail($userEmail)) {
                $_SESSION['account']->setEmail($userEmail);
            } else {
                $this->_f3->set('errors["email"]', "Email required - @email.com format"); // if data is not valid set error message in HIVE
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
            if(empty($this->_f3->get('errors')) && $account->getIsPremium()){
                $this->_f3->reroute('/create3');
            } else {
                $this->_f3->reroute('/summary');
            }
        }

        // Sticky Variables
        $this->_f3->set('userEmail', isset($userEmail) ? $userEmail : "");

        $view = new Template();
        echo $view->render('views/create2.html');
    }

    function create3(){
        global $dataLayer;

        $this->_f3->set('indoor', $dataLayer->getIndoorInterests());
        $this->_f3->set('outdoor', $dataLayer->getOutdoorInterests());

        if(isset($_POST['interests'])){
            $interestString = implode(", ", $_POST['interests']);
            $_SESSION['account']->setInterests($interestString);
        }

        $view = new Template();
        echo $view->render('views/create3.html');
    }

    function summary(){
        global $dataLayer;
        global $member;
        //var_dump($_SESSION);
        $member = $_SESSION['account'];

        if(isset($_POST['interests'])){
            $this->_f3->set('interests', implode(", ",$_POST['interests']));
            $interestString = implode(", ", $_POST['interests']);
            $_SESSION['account']->setInterests($interestString);
        }
        $dataLayer->insertMember($member);

        $view = new Template();
        echo $view->render('views/summary.html');
        session_destroy();
    }

    function admin(){
        global $dataLayer;
        $members = $dataLayer->getMembers();
        $this->_f3->set('members', $members);


        $view = new Template();
        echo $view->render('views/admin.html');
    }

}