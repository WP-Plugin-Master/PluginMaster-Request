<?php

namespace PluginMaster\Request;

use PluginMaster\Request\base\RequestBase;

class Request extends RequestBase
{

    protected $all = [];

    function __construct()
    {
        $this->requestInit();
    }



    public function isMethod($method)
    {
        if (strtoupper($method) === $_SERVER['REQUEST_METHOD']) {
            return true;
        }
        return false;
    }


    /**
     *
     * set all requested data as this class property;
     */
    protected function requestInit()
    {
        $this->postDataSet();
        $this->ajaxDataSet();
        $this->getDataSet();
    }

    /**
     *set server global data as this class property
     */
    protected function postDataSet()
    {
        foreach ($_POST as $key => $value) {
            $this->{$key} = $value;
            $this->all[$key] = $value;
        }

    }

    /**
     *set server global data as this class property
     */
    protected function ajaxDataSet()
    {
        $inputJSON = file_get_contents('php://input');
        if (empty($_POST)  && $inputJSON) {
            $input = json_decode($inputJSON, true);
            if ($input &&  gettype($input) === 'array') {
                foreach ($input as $key => $value) {
                    $this->{$key} = $value;
                    $this->all[$key] = $value;
                }
            }
        }

    }

    /**
     *set server global data as this class property
     */
    protected function getDataSet()
    {
        foreach ($_GET as $key => $value) {
            $this->{$key} = $value;
            $this->all[$key] = $value;
        }

    }


    /**
     * set all requested data as this class property;
     */
    public function all()
    {
        return $this->all;
    }

    /**
     * @param $property
     * @return |null
     */
    public function get($key)
    {
        return isset($this->{$key}) ? $this->{$key} : null;
    }


    /**
     * @param $key
     * @return mixed|null |null
     */
    public function header($key)
    {
        return isset(getallheaders()[$key]) ? getallheaders()[$key] : null;
    }



    /**
     * @param $property
     * @return |null
     */
    public function __get($property)
    {
        return isset($this->{$property}) ? $this->{$property} : null;
    }


}
