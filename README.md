Thirdwatch Magento Extension
=====================
This extention will send the orders placed in magento store to thirdwatch for validation. Thirdwatch will identity the parameters in the orders and mark flag on them.

Facts
-----
- version: 0.1.0

Description
-----------
Three status will be added in the magento store configuration, namely,
- Under Review (Thirdwatch)
- Approved (Thirdwatch)
- Declined (Thirdwatch)
Once the order is sent to thirdwatch, the status will be "Under Review (Thirdwatch)". Now after processing the order at thirdwatch, a postback request to the store will be made which will update the order based on the flag raised by thirdwatch.

Requirements
------------
- PHP >= 5.6.0
- Mage_Core

Compatibility
-------------
- Magento >= 1.9

Installation Instructions
-------------------------

1. directly from github - download the latest release from the release section and merge the code with the magento core files by following the tree structure.
2. via the Magento Connect system ( Coming Soon )
3. using Modman with the modman file in the repository ( Coming Soon )


Uninstallation
--------------
1. Remove all extension files from your Magento installation

Support
-------
If you have any issues with this extension, contact the developer.

Developer
---------
Tarun Razdan
tarun@thirdwatch.ai

License
-------
[OSL - Open Software Licence 3.0](http://opensource.org/licenses/osl-3.0.php)

Copyright
---------
(c) 2017 Thirdwatch Data Private Limited 