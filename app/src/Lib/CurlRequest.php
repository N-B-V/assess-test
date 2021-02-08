<?php

namespace App\Lib;

class CurlRequest implements CurlRequestInterface
{
    private $handle = null;

//    public function __construct($url) {
//        $this->handle = curl_init($url);
//    }

    public function setURL($url) {
        $this->handle = curl_init($url);
    }

    public function setOption($name, $value) {
        curl_setopt($this->handle, $name, $value);
    }

    public function execute() {
        $exec = curl_exec($this->handle);

        if (curl_errno($this->handle)) {
            var_dump(curl_error($this->handle));
            exit;
        }
        return $exec;
    }

    public function close() {
        curl_close($this->handle);
    }
}