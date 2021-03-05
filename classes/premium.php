<?php

class Premium extends Member
{

    private $_inDoorInterests;
    private $_outDoorInterests;



    /**
     * Premium constructor.
     * @param $_fname
     * @param $_lname
     * @param $_age
     * @param $_gender
     * @param $_phone
     * @param bool $_isPremium
     * @param array $_inDoorInterests
     * @param array $_outDoorInterests
     */
    public function __construct($_fname, $_lname, $_age, $_gender, $_phone, $_isPremium = true, $_inDoorInterests = [], $_outDoorInterests = [])
    {
        parent::__construct($_fname, $_lname, $_age, $_gender, $_phone, $_isPremium);
        $this->_inDoorInterests = $_inDoorInterests;
        $this->_outDoorInterests = $_outDoorInterests;
    }


    /**
     * @return array
     */
    public function getInDoorInterests()
    {
        return $this->_inDoorInterests;
    }

    /**
     * @param array $inDoorInterests
     */
    public function setInDoorInterests($inDoorInterests)
    {
        $this->_inDoorInterests = $inDoorInterests;
    }

    /**
     * @return array
     */
    public function getOutDoorInterests()
    {
        return $this->_outDoorInterests;
    }

    /**
     * @param array $outDoorInterests
     */
    public function setOutDoorInterests($outDoorInterests)
    {
        $this->_outDoorInterests = $outDoorInterests;
    }

}