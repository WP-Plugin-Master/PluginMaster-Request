<?php


namespace PluginMaster\Request\base;


abstract class RequestBase
{
    abstract public function all();

    abstract public function get($property);

    abstract protected function requestInit();

    abstract protected function postDataSet();

    abstract protected function ajaxDataSet();

    abstract protected function getDataSet();

}
