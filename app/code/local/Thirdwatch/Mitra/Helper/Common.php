<?php
require_once(Mage::getBaseDir('lib') . DIRECTORY_SEPARATOR . 'thirdwatch-php' . DIRECTORY_SEPARATOR . 'autoload.php');
use \ai\thirdwatch\Api;
use \ai\thirdwatch\Model;
use \ai\thirdwatch\Common;


class Thirdwatch_Mitra_Helper_Common extends Mage_Core_Helper_Abstract
{

    public function getShippingAddress($model)
    {
        $address =  $this->getAddress($model);
        $shipping_json = new \ai\thirdwatch\Model\ShippingAddress($address);
        return $shipping_json;

    }

    public function getBillingAddress($model)
    {
        $address =  $this->getAddress($model);
        $billing_json = new \ai\thirdwatch\Model\BillingAddress($address);
        return $billing_json;
    }

    private function getAddress($address)
    {
        if (!$address) {
            return null;
        }

        $street = $address->getStreet();
        $address_1 = (!is_null($street) && array_key_exists('0', $street)) ? $street['0'] : null;
        $address_2 = (!is_null($street) && array_key_exists('1', $street)) ? $street['1'] : null;

        $addrArray = array_filter(array(
            '_name' => $address->getFirstname() . " " . $address->getLastname(),
            '_address1' => $address_1,
            '_address2' => $address_2,
            '_city' => $address->getCity(),
            '_country' => Mage::getModel('directory/country')->load($address->getCountryId())->getCountryId(),
            '_region' => $address->getRegion(),
            '_zipcode' => $address->getPostcode(),
            '_phone' => $address->getTelephone(),
        ), 'strlen');

        if (!$addrArray) {
            return null;
        }
        return $addrArray;
    }

}