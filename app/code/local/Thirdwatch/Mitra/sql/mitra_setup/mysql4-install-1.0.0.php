<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$helper = Mage::helper('mitra/order_status');

Mage::getModel('sales/order_status')
    ->setStatus($helper->getThirdwatchDeclinedStatusCode())
    ->setLabel($helper->getThirdwatchDeclinedStatusLabel())
    ->assignState(Mage_Sales_Model_Order::STATE_CANCELED)
    ->save();

Mage::getModel('sales/order_status')
    ->setStatus($helper->getThirdwatchApprovedStatusCode())
    ->setLabel($helper->getThirdwatchApprovedStatusLabel())
    ->assignState(Mage_Sales_Model_Order::STATE_PROCESSING)
    ->save();

Mage::getModel('sales/order_status')
    ->setStatus($helper->getOnHoldStatusCode())
    ->setLabel($helper->getOnHoldStatusLabel())
    ->assignState(Mage_Sales_Model_Order::STATE_HOLDED)
    ->save();

Mage::getModel('sales/order_status')
    ->setStatus($helper->getThirdwatchFlaggedStatusCode())
    ->setLabel($helper->getThirdwatchFlaggedStatusLabel())
    ->assignState(Mage_Sales_Model_Order::STATE_HOLDED)
    ->save();

$installer->endSetup();
