<?php
/*
 * Function to hold array of indoor interests
 */
class DataLayer
{
    function getIndoorInterests(){
        return array("tv", "movies", "cooking", "board games", "puzzles", "reading", "playing cards", "video games", "napping", "baking");
    }

    /*
     * Function to hold array of outdoor interests
     */
    function getOutdoorInterests(){
        return array("hiking", "biking", "swimming", "collecting", "walking", "climbing", "camping", "athletics", "kayaking", "beaches");
    }
}