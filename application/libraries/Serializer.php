<?php

class Serializer {

    private $_serializer = null;

    public function __construct()
    {
        require_once APPPATH.'vendor/autoload.php';

        $this->_serializer = \JMS\Serializer\SerializerBuilder::create()->build();
    }

    /**
     * @return \JMS\Serializer\Serializer
     */
    public function GetSerializer() : \JMS\Serializer\Serializer
    {
        return $this->_serializer;
    }
}