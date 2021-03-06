<?php

class PremiumMember extends Member
{

    private $_inDoorInterests = array();
    private $_outDoorInterests = array();

    /**
     * PremiumMember constructor.
     * @param array $_inDoorInterests
     * @param array $_outDoorInterests
     */
    public function __construct(array $_inDoorInterests, array $_outDoorInterests)
    {
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