<?php
require_once(Mage::getBaseDir('lib') . DIRECTORY_SEPARATOR . 'thirdwatch-php' . DIRECTORY_SEPARATOR . 'autoload.php');
use \ai\thirdwatch\Api;
use \ai\thirdwatch\Model;
use \ai\thirdwatch\Common;

class Thirdwatch_Mitra_Helper_Register extends Mage_Core_Helper_Abstract
{
    public function postRegister($customer)
    {
        $helper = Mage::helper('mitra');
        $thirdwatchKey = $helper->getKey();
        $config = ai\thirdwatch\Configuration::getDefaultConfiguration()->setApiKey('X-THIRDWATCH-API-KEY', $thirdwatchKey);

        $customerInfo = array();
        $customerData = Mage::getModel('customer/customer')->load($customer->getId());
        $session = Mage::getSingleton('core/session');
        $SID=$session->getEncryptedSessionId();

        try{
            $currentDate = Varien_Date::now();
            $currentTimestamp = Varien_Date::toTimestamp($currentDate);
            $remoteAddress = Mage::helper('core/http')->getRemoteAddr();

            $customerInfo['_user_id'] = (string) $customerData->getId();
            $customerInfo['_session_id'] = (string) $SID;
            $customerInfo['_device_ip'] = (string) $remoteAddress;
            $customerInfo['_origin_timestamp'] = (string) $currentTimestamp . '000';
            $customerInfo['_user_email'] = (string) $customerData->getEmail();
            $customerInfo['_first_name'] = (string) $customerData->getFirstname();
            $customerInfo['_last_name'] = (string) $customerData->getLastname();

            if ($customerData->getPrimaryBillingAddress()){
                $customerInfo['_phone'] = (string) $customerData->getPrimaryBillingAddress()->getTelephone();
            }

            $isActive = $customerData->getIsActive();
            if ($isActive){
                $customerInfo['_account_status'] = '_active';
            }
            else{
                $customerInfo['_account_status'] = '_inactive';
            }

            $api_instance = new \ai\thirdwatch\Api\CreateAccountApi(new GuzzleHttp\Client(), $config);
            $body = new \ai\thirdwatch\Model\CreateAccount($customerInfo);
        }
        catch (Exception $e){
            Mage::helper('mitra/log')->log($e->getMessage());
        }

        try {
            $result = $api_instance->createAccount($body);
        } catch (Exception $e) {
            Mage::helper('mitra/log')->log($e->getMessage());
        }
    }

    public function postCustomerUpdate($customer)
    {
        $helper = Mage::helper('mitra');
        $thirdwatchKey = $helper->getKey();
        $config = ai\thirdwatch\Configuration::getDefaultConfiguration()->setApiKey('X-THIRDWATCH-API-KEY', $thirdwatchKey);

        $customerInfo = array();
        $customerData = Mage::getModel('customer/customer')->load($customer->getId());
        $session = Mage::getSingleton('core/session');
        $SID=$session->getEncryptedSessionId();

        try{
            $currentDate = Varien_Date::now();
            $currentTimestamp = Varien_Date::toTimestamp($currentDate);
            $remoteAddress = Mage::helper('core/http')->getRemoteAddr();

            $customerInfo['_user_id'] = (string) $customerData->getId();
            $customerInfo['_session_id'] = (string) $SID;
            $customerInfo['_device_ip'] = (string) $remoteAddress;
            $customerInfo['_origin_timestamp'] = (string) $currentTimestamp . '000';
            $customerInfo['_user_email'] = (string) $customerData->getEmail();
            $customerInfo['_first_name'] = (string) $customerData->getFirstname();
            $customerInfo['_last_name'] = (string) $customerData->getLastname();

            if ($customerData->getPrimaryBillingAddress()){
                $customerInfo['_phone'] = (string) $customerData->getPrimaryBillingAddress()->getTelephone();
            }

            $isActive = $customerData->getIsActive();
            if ($isActive){
                $customerInfo['_account_status'] = '_active';
            }
            else{
                $customerInfo['_account_status'] = '_inactive';
            }

            $customerInfo['_billing_address'] = Mage::helper('mitra/common')->getBillingAddress($customerData->getPrimaryBillingAddress());
            $customerInfo['_shipping_address'] = Mage::helper('mitra/common')->getShippingAddress($customerData->getPrimaryShippingAddress());

            $api_instance = new \ai\thirdwatch\Api\UpdateAccountApi(new GuzzleHttp\Client(), $config);
            $body = new \ai\thirdwatch\Model\UpdateAccount($customerInfo);
        }
        catch (Exception $e){
            Mage::helper('mitra/log')->log($e->getMessage());
        }

        try {
            $result = $api_instance->UpdateAccount($body);
        } catch (Exception $e) {
            Mage::helper('mitra/log')->log($e->getMessage());
        }
    }
}