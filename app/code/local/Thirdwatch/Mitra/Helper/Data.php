<?php

/*
 * To fetch config data and return.
 */
class Thirdwatch_Mitra_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getKey(){
        return Mage::getStoreConfig('thirdwatch/thirdwatch_group/secret_key', Mage::app()->getStore());
    }

    public function getStoreURL(){
        return Mage::getStoreConfig('thirdwatch/thirdwatch_group/store_url', Mage::app()->getStore());
    }

    public function isPluginActive(){
        return Mage::getStoreConfig('thirdwatch/thirdwatch_group/plugin_active', Mage::app()->getStore());
    }
}
