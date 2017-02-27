<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/26/2017
 * Time: 11:37 AM
 */

namespace libraries;


class AjaxResponse
{
    /** @var  $_data */
    private $_data;

    /** @var bool */
    private $_success;

    /** @var string */
    private $_error = "";

    /** @var \Serializer */
    private $_serializer;

    public function __construct(bool $success)
    {
        $this->_success = $success;
        $this->_serializer = new \Serializer();
    }

    /**
     * @return object
     */
    public function GetData() : object
    {
        return $this->_data;
    }

    /**
     * @param $data
     * @return AjaxResponse
     */
    public function SetData($data) : AjaxResponse
    {
        $this->_data = $data;
        return $this;
    }

    /**
     * @return bool
     */
    public function GetSuccess() : bool
    {
        return $this->_success;
    }

    /**
     * @param bool $success
     * @return AjaxResponse
     */
    public function SetSuccess(bool $success) : AjaxResponse
    {
        $this->_success = $success;
        return $this;
    }

    /**
     * @return string
     */
    public function GetError() : string
    {
        return $this->_error;
    }

    /**
     * @param string $message
     * @return AjaxResponse
     */
    public function SetError(string $message) : AjaxResponse
    {
        $this->_error = $message;
        return $this;
    }

    /**
     * @return void
     */
    public function ReturnResult() : void
    {
        $result = [
            'success' => $this->_success,
            'error' => $this->_error,
            'data' => $this->_data
        ];

        echo $this->_serializer->GetSerializer()->serialize($result, 'json');
    }
}