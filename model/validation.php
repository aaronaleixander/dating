<?php
/**
 * This function will check to see that the name input is not empty and that all characters are alphabetic.
 * */
class Validate
{
    private $_dataLayer;

    public function __construct($dataLayer){
        $this->_dataLayer = $dataLayer;
    }
    function validName($name)
    {
        return !empty($name) && ctype_alpha($name);
    }

    /**
     * This function will check that age is non empty and that users are older then 18 and younger then 118
     */
    function validAge($age)
    {
        $minAge = 18;
        $maxAge = 118;
        return !empty($age) && ($age >= $minAge && $age <= $maxAge);
    }

    /**
     * This function will check that phone is 10 characters, with dashes, and numbers 0 - 9.
     */
    function validPhone($phonenumber)
    {
        if (preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phonenumber)) {
            return true;
        }
        return false;
    }

    /**
     * This function will check that e mail is valid using FILTER_VALIDATE_EMAIL
     */
    function validEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    /**
     * This function will check that at least one indoor activity is selected and valid selection from the
     * array of indoor activities
     */
    function validIndoor()
    {
        $validIndoorActivities = array("tv", "movies", "cooking", "board games", "puzzles", "reading", "playing cards", "video games", "napping", "baking");
        return true;
    }

    /**
     * This function will check that at least one outdoor activity is selected and valid selection from the
     * array of outdoor activities
     */
    function validOutdoor()
    {
        $validOutdoorActivities = array("hiking", "biking", "swimming", "collecting", "walking", "climbing", "camping", "athletics", "kayaking", "beaches");
        return true;
    }
}



