# The Problem

We prepare our Magento build using a CI, which uses composer to pull the various components in, and modman to link them into place in the document root before zipping them up for deployment. However, the Magento plugin doesn't work as expected when installed in this manner.

As part of the plugin's build process, it merges a copy of the classes from the 'php-client' module into it's own 'lib/Bitpay' folder, so that they are all installed to Magento's lib folder, and Magento's own classloader can take care of it all.

When using the composer approach, composer pulls the 'magento-plugin' source in and sticks it in composer's vendor folder as expected, without building it. This means the 'lib/Bitpay' folder in the document root then only contains the Bitpay_Storage_MagentoStorage class, and not the other Bitpay classes that the build pulls in from the 'php-client' lib. Things break because it can't find 'Bitpay_Client' when it needs to.

Additionally, because the 'php-client' library gets installed into our 'vendor' folder, which sits outside of the document root in our setup, so those classes will never be found unless we configure the classloading. If the standard classloader from the 'php-client' library is invoked, it will find it's own classes fine, but won't find the MagentoStore class from Magento's lib folder.

# A Solution

A classloader that acts much like php-client's classloader, but will also check the Magento lib folder if it couldn't find it in composer's vendor folder?

In our case, the project root contains the 'vendor' folder, and the document root contains the 'lib' folder. We have them configured using the environment variables 'MAGE_PROJECT_DIR' and 'MAGE_DOC_ROOT'.

Required composer.json changes...

```json
{
    "repositories" {
        "rossigee/magento-bitpay": "^0.1"
        "bitpay/magento-plugin": "2.1.10.1",
        "bitpay/php-client": "dev-master#9027ce67e4b28516ff1ebd1046bdd15c37a7a59f"
    }
}
```

