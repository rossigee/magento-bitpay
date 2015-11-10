<?php
/**
 * @license Copyright 2011-2015 BitPay Inc., MIT License 
 * see https://github.com/bitpay/php-bitpay-client/blob/master/LICENSE
 *
 * Hacked to search both composer's 'vendor' and Magento's 'lib' folder for
 * classes in the 'BitPay' namespace.
 */

/**
 * @package Rossigee_Core_Bitpay
 */
class Rossigee_Core_BitPay_Autoloader
{
    /**
     * Register the autoloader, by default this will put the BitPay autoloader
     * first on the stack, to append the autoloader, pass `false` as an argument.
     *
     * Some applications will throw exceptions if the class isn't found and
     * some are not compatible with PSR standards.
     *
     * @param boolean $prepend
     * @throws \Exception
     */
    public static function register($prepend = true)
    {
        if (false === spl_autoload_register(array(__CLASS__, 'autoload'), true, (bool)$prepend)) {
            throw new \Exception('[ERROR] In Autoloader::register(): Call to spl_autoload_register() failed.');
        }
    }

    /**
     * Unregister this autoloader.
     *
     * @param boolean $ignoreFailures
     * @throws \Exception
     */
    public static function unregister($ignoreFailures = true)
    {
        if (false === spl_autoload_unregister(array(__CLASS__, 'autoload'))) {
            if ($ignoreFailures === false) {
                throw new \Exception('[ERROR] In Autoloader::unregister(): Call to spl_autoload_unregister() failed.');
            }
        }
    }

    /**
     * Give a class name and it will require the file.
     *
     * @param  string $class
     * @return bool|null
     * @throws \Exception
     */
    public static function autoload($class)
    {
        if (0 === strpos($class, 'Bitpay\\')) {
            $classname = substr($class, 7);

            $vendor_dir = getenv("MAGE_PROJECT_DIR") . DIRECTORY_SEPARATOR . join(DIRECTORY_SEPARATOR, array("vendor", "bitpay", "php-client", "src", "Bitpay"));
            $file = $vendor_dir . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $classname) . '.php';

            if (is_file($file) && is_readable($file)) {
                require_once $file;

                return true;
            }

            $mage_lib_dir = getenv("MAGE_DOC_ROOT") . DIRECTORY_SEPARATOR. join(DIRECTORY_SEPARATOR, array("lib", "Bitpay"));
            $file = $mage_lib_dir . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $classname) . '.php';

            if (is_file($file) && is_readable($file)) {
                require_once $file;

                return true;
            }

            throw new \Exception('[ERROR] In Autoloader::autoload(): Class "' . $class . '" Not Found');
        }
    }
}

