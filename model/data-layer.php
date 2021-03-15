<?php
/*
 * Function to hold array of indoor interests
 */
class DataLayer
{
    private $_dbh;

    function __construct($dbh)
    {
        $this->_dbh = $dbh;
    }

    /**
     * This function will insert a new dating member into the database
     * @return string[] $result the member that was added to the database
     */
    function insertMember($member){
        //Define the query
        $sql = "INSERT INTO member(fname, lname, age, gender, phone, email, state, seeking, bio, premium, interests) 
	            VALUES (:fname, :lname, :age, :gender, :phone, :email, :state, :seeking, :bio, :premium, :interests)";

        //Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //Bind the parameters
        $statement->bindParam(':fname', $member->getFname(), PDO::PARAM_STR);
        $statement->bindParam(':lname', $member->getLname(), PDO::PARAM_STR);
        $statement->bindParam(':age', $member->getAge(), PDO::PARAM_INT);
        $statement->bindParam(':gender', $member->getGender(), PDO::PARAM_STR);
        $statement->bindParam(':phone', $member->getPhone(), PDO::PARAM_STR);
        $statement->bindParam(':email', $member->getEmail(), PDO::PARAM_STR);
        $statement->bindParam(':state', $member->getState(), PDO::PARAM_STR);
        $statement->bindParam(':seeking', $member->getSeeking(), PDO::PARAM_STR);
        $statement->bindParam(':bio', $member->getBio(), PDO::PARAM_STR);
        $statement->bindParam(':premium', $member->getIsPremium(), PDO::PARAM_BOOL);
        $statement->bindParam(':interests', $member->getInterests(), PDO::PARAM_STR);


        //Execute
        $statement->execute();
        $id = $this->_dbh->lastInsertId();
        echo "$id";
    }

    /**
     * This function will get all the members that are signed up for the dating
     * application, from the member table in the database.
     * @return string[] $result the members that are added to the database
     */
    function getMembers(){
        //Define the query
        $sql = "SELECT * FROM member";

        //Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //Execute
        $statement->execute();

        //Get the results
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * This function will get a single member that is signed up for the dating
     * application, from the member table in the database.
     * @return string[] $result the member that was added to the database
     */
    function getMember($member_id){
        //Define the query
        $sql = "SELECT * FROM member WHERE member_id = $member_id";

        //Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //Execute
        $statement->execute();

        //Get the results
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        //var_dump($result);
        return $result;
    }

    /**
     * This function will get the interests for a single premium member that is signed up for the dating
     * application, from the member table in the database.
     * @return string[] $result the interests of premium member
     */
    function getInterests($member_id){

    }

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