<?php

class Rossigee_Core_Model_Observer {
    const AUTOLOADER_FILE = dirname(__DIR__) . DIRECTORY_SEPARATOR . "Bitpay" . DIRECTORY_SEPARATOR . "Autoloader.php";

    public function addAutoloader() {
        require_once self::AUTOLOADER_FILE;
        return $this;
    }
}

