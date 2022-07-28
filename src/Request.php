<?php

namespace PluginMaster\Request;

use PluginMaster\Contracts\Request\RequestInterface;

class Request implements RequestInterface
{

    protected array $data = [];
    protected array $headers = [];

    function __construct()
    {
        $this->setAjaxData();
        $this->setGetData();
        $this->setPostData();
        $this->setRequestHeaders();
    }

    private function setPostData()
    {
        foreach ($_POST as $key => $value) {
            $this->data[$key] = $value;
        }
    }


    private function setAjaxData()
    {
        $inputJSON = file_get_contents('php://input');
        if (empty($_POST) && $inputJSON) {
            $input = json_decode($inputJSON, true);
            if ($input && gettype($input) === 'array') {
                foreach ($input as $key => $value) {
                    $this->data[$key] = $value;
                }
            }
        }
    }


    private function setGetData()
    {
        foreach ($_GET as $key => $value) {
            $this->data[$key] = $value;
        }
    }

    private function setRequestHeaders()
    {
        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) <> 'HTTP_') {
                continue;
            }
            $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
            $this->headers[$header] = $value;
        }
    }


    public function isMethod(string $method): bool
    {
        if (strtoupper($method) === $_SERVER['REQUEST_METHOD']) {
            return true;
        }
        return false;
    }


    /**
     * set all requested data as this class property;
     */
    public function all(): array
    {
        return $this->data;
    }

    /**
     * @param  string  $key
     * @return mixed|null
     */
    public function get(string $key): mixed
    {
        return $this->data[$key] ?? null;
    }

    /**
     * @param  string  $key
     * @return mixed|null
     */
    public function header(string $key):mixed
    {
        return $this->headers[$key] ?? null;
    }

    public function url(): string
    {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")."://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

    /**
     * @param $property
     * @return mixed|null
     */
    public function __get($property)
    {
        return $this->data[$property] ?? null;
    }

}
