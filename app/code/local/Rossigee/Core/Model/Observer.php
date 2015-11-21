<?php

class Rossigee_Core_Model_Observer {
    public function addAutoloader() {
        $file = getenv("MAGE_DOC_ROOT") . "/app/code/local/Rossigee/Core/Bitpay/Autoloader.php";
        if(!file_exists($file)) {
            $file = dirname(__DIR__) . DIRECTORY_SEPARATOR . "Bitpay" . DIRECTORY_SEPARATOR . "Autoloader.php";
        }
        require_once $file;
        Rossigee_Core_Bitpay_Autoloader::register();
        return $this;
    }
}

