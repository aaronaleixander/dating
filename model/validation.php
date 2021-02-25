<?php
/**
 * This function will check to see that the name input is not empty and that all characters are alphabetic.
 * */
function validName($name){
    return !empty($name) && ctype_alpha($name);
}

/**
 * This function will check that age is non empty and that users are older then 18 and younger then 118
 */
function validAge($age){
    $minAge = 18;
    $maxAge = 118;
    return !empty($age) && ($age >= $minAge && $age <= $maxAge);
}

/**
 * This function will check that phone is 10 characters, with dashes, and numbers 0 - 9.
 */
function validPhone($phone){
    if(preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phone)) {
        return true;
    }
    return false;
}

/**
 * This function will check that e mail is valid using FILTER_VALIDATE_EMAIL
 */
function validEmail($email){
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    return true;
}

