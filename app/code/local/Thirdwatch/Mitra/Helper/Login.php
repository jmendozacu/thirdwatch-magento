<?php
require_once(Mage::getBaseDir('lib') . DIRECTORY_SEPARATOR . 'thirdwatch_php_sdk' . DIRECTORY_SEPARATOR . 'autoload.php');
use \Swagger\Client\Api;
use \Swagger\Client\Model;
use \Swagger\Client\Common;

class Thirdwatch_Mitra_Helper_Login extends Mage_Core_Helper_Abstract
{
    public function postLogin($customer)
    {
        $helper = Mage::helper('mitra');
        $thirdwatchKey = $helper->getKey();
        \Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('X-THIRDWATCH-API-KEY', $thirdwatchKey);

        $customerData = Mage::getModel('customer/customer')->load($customer->getId());
        $customerInfo = array();
        $session = Mage::getSingleton('core/session');
        $SID = $session->getEncryptedSessionId();

        try{
            $currentDate = Varien_Date::now();
            $currentTimestamp = Varien_Date::toTimestamp($currentDate);
            $remoteAddress = Mage::helper('core/http')->getRemoteAddr();

            $customerInfo['_user_id'] = (string) $customerData->getId();
            $customerInfo['_session_id'] = (string) $SID;
            $customerInfo['_device_ip'] = (string) $remoteAddress;
            $customerInfo['_origin_timestamp'] = (string) $currentTimestamp . '000';
            $customerInfo['_login_status'] = "_success";

            $api_instance = new \Swagger\Client\Api\LoginApi();
            $body = new \Swagger\Client\Model\Login($customerInfo);
        }
        catch (Exception $e){
            Mage::helper('mitra/log')->log($e->getMessage());
        }

        try {
            $result = $api_instance->login($body);
        } catch (Exception $e) {
            Mage::helper('mitra/log')->log($e->getMessage());
        }
    }

    public function postLogout($customer){
        $helper = Mage::helper('mitra');
        $thirdwatchKey = $helper->getKey();
        \Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('X-THIRDWATCH-API-KEY', $thirdwatchKey);

        $customerData = Mage::getModel('customer/customer')->load($customer->getId());
        $customerInfo = array();
        $session = Mage::getSingleton('core/session');
        $SID = $session->getEncryptedSessionId();

        try{
            $currentDate = Varien_Date::now();
            $currentTimestamp = Varien_Date::toTimestamp($currentDate);
            $remoteAddress = Mage::helper('core/http')->getRemoteAddr();
            $customerInfo['_user_id'] = (string) $customerData->getId();
            $customerInfo['_session_id'] = (string) $SID;
            $customerInfo['_device_ip'] = (string) $remoteAddress;
            $customerInfo['_origin_timestamp'] = (string) $currentTimestamp . '000';
            $customerInfo['_login_status'] = "_success";

            $api_instance = new \Swagger\Client\Api\LogoutApi();
            $body = new \Swagger\Client\Model\Logout($customerInfo);
        }
        catch (Exception $e){
            Mage::helper('mitra/log')->log($e->getMessage());
        }

        try {
            $result = $api_instance->logout($body);
        } catch (Exception $e) {
            Mage::helper('mitra/log')->log($e->getMessage());
        }
    }
}