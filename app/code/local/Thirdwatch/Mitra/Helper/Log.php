<?php

class Thirdwatch_Mitra_Helper_Log extends Mage_Core_Helper_Abstract
{
    public function log($message, $level = null)
    {
        Mage::log($message, $level, 'thirdwatch_full.log');
    }

    public function logException($e)
    {
        $this->log("Thirdwatch extension had an exception: " . $e->getMessage());
    }
}