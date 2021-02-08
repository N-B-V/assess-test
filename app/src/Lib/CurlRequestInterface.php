<?php

namespace App\Lib;

interface CurlRequestInterface
{
    function setURL($url);
    public function setOption($name, $value);
    public function execute();
    public function close();
}