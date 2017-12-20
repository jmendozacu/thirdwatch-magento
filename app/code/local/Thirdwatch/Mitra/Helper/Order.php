<?php

require_once(Mage::getBaseDir('lib') . DIRECTORY_SEPARATOR . 'thirdwatch-php' . DIRECTORY_SEPARATOR . 'autoload.php');

class Thirdwatch_Mitra_Helper_Order extends Mage_Core_Helper_Abstract
{

    const ACTION_CREATE = 'create';
    const ACTION_TRANSACTION = 'transaction';
    const ACTION_UPDATE = 'update';
    const ACTION_CANCEL = 'cancel';
    const ACTION_REFUND = 'refund';
    const ACTION_ONLY_TRANSACTION = 'onlyTransaction';

    private $_customer = array();
    protected $requestData = array();

    /*
     * Submit an order to Thirdwatch.
     * @param Mage_Sales_Model_Order $order
     * @param string $action - one of self::ACTION_*
     */
    public function postOrder($order, $action)
    {
        switch ($action) {
            case self::ACTION_CREATE:
                Mage::helper('mitra/log')->log("ACTION_CREATE");
                $this->createOrder($order);
                break;
            case self:: ACTION_TRANSACTION:
                Mage::helper('mitra/log')->log("ACTION_TRANSACTION");
                $this->createOrder($order);
                $this->createTransaction($order, '_sale');
                $order->setState(Mage_Sales_Model_Order::STATE_HOLDED, 'thirdwatch_holded');
                $order->save();
                break;
            case self:: ACTION_CANCEL:
                Mage::helper('mitra/log')->log("ACTION_CANCEL");
                $this->createTransaction($order, '_void');
                break;
            case self:: ACTION_REFUND:
                Mage::helper('mitra/log')->log("ACTION_REFUND");
                $this->createTransaction($order, '_refund');
                break;
            case self:: ACTION_ONLY_TRANSACTION:
                Mage::helper('mitra/log')->log("ACTION_ONLY_TRANSACTION");
                $this->createTransaction($order, '_sale');
                $order->setState(Mage_Sales_Model_Order::STATE_HOLDED, 'thirdwatch_holded');
                $order->save();
                break;
            case self::ACTION_UPDATE:
                Mage::helper('mitra/log')->log("ACTION_UPDATE");
                $this->updateOrderStatus($order);
                break;
        }
    }

    public function getOrderOrigId($order)
    {
        if (!$order) {
            return null;
        }
        return $order->getId() . '_' . $order->getIncrementId();
    }

    /**
     * This function is called whenever an item is added to the cart or removed from the cart.
     */
    private function getLineItemData($val)
    {
        $prodType = null;
        $category = null;
        $subCategories = null;
        $brand = null;
        $product = Mage::getModel('catalog/product')->load($val->getProductId());

        if ($product) {
            $categoryIds = $product->getCategoryIds();
            foreach ($categoryIds as $categoryId) {
                $cat = Mage::getModel('catalog/category')->load($categoryId);
                $catName = $cat->getName();
                if (!empty($catName)) {
                    if (empty($category)) {
                        $category = $catName;
                    } else if (empty($subCategories)) {
                        $subCategories = $catName;
                    } else {
                        $subCategories = $subCategories . '|' . $catName;
                    }
                }
            }

            if ($product->getManufacturer()) {
                $brand = $product->getAttributeText('manufacturer');
            }
        }

        $currencyCode = Mage::app()->getStore()->getCurrentCurrencyCode();
        $countryCode = Mage::getStoreConfig('general/country/default');

        $lineItemData = array();
        $lineItemData['_price'] = (string) $val->getRowTotalInclTax();
        $lineItemData['_quantity'] = intval($val->getQty());
        $lineItemData['_product_title'] = (string) $val->getName();
        $lineItemData['_sku'] = (string) $val->getSku();
        $lineItemData['_item_id'] = (string) $product->getId();
        $lineItemData['_product_weight'] = (string) $val->getWeight();
        $lineItemData['_category'] = (string) $category;
        $lineItemData['_brand'] = (string) $brand;
        $lineItemData['_description'] = (string) $product->getDescription();
        $lineItemData['_description_short'] = (string) $product->getShortDescription();
        $lineItemData['_manufacturer'] = (string)$brand;
        $lineItemData['_currency_code'] = (string)$currencyCode;
        $lineItemData['_country'] = (string)$countryCode;

        $itemJson = new \ai\thirdwatch\Model\Item($lineItemData);
        return $itemJson;
    }

    /**
     * This function is called whenever an order is placed.
     */
    private function getOrderItemData($val)
    {
        $prodType = null;
        $category = null;
        $subCategories = null;
        $brand = null;
        $product = Mage::getModel('catalog/product')->load($val->getProductId());

        if ($product) {
            $prodType = $product->getTypeId();
            $categoryIds = $product->getCategoryIds();
            foreach ($categoryIds as $categoryId) {
                $cat = Mage::getModel('catalog/category')->load($categoryId);
                $catName = $cat->getName();
                if (!empty($catName)) {
                    if (empty($category)) {
                        $category = $catName;
                    } else if (empty($subCategories)) {
                        $subCategories = $catName;
                    } else {
                        $subCategories = $subCategories . '|' . $catName;
                    }
                }
            }

            if ($product->getManufacturer()) {
                $brand = $product->getAttributeText('manufacturer');
            }
        }

        $currencyCode = Mage::app()->getStore()->getCurrentCurrencyCode();
        $countryCode = Mage::getStoreConfig('general/country/default');

        $lineItemData = array();
        $lineItemData['_price'] = (string) $val->getPrice();
        $lineItemData['_quantity'] = intval($val->getQtyOrdered());
        $lineItemData['_product_title'] = (string) $val->getName();
        $lineItemData['_sku'] = (string) $val->getSku();
        $lineItemData['_item_id'] = (string) $product->getId();
        $lineItemData['_product_weight'] = (string) $val->getWeight();
        $lineItemData['_category'] = (string) $category;
        $lineItemData['_brand'] = (string) $brand;
        $lineItemData['_description'] = (string) $product->getDescription();
        $lineItemData['_description_short'] = (string) $product->getShortDescription();
        $lineItemData['_manufacturer'] = (string)$brand;
        $lineItemData['_currency_code'] = (string)$currencyCode;
        $lineItemData['_country'] = (string)$countryCode;

        $itemJson = new \ai\thirdwatch\Model\Item($lineItemData);
        return $itemJson;
    }

    public function postCart($item){
        $helper = Mage::helper('mitra');
        $thirdwatchKey = $helper->getKey();
        \ai\thirdwatch\Configuration::getDefaultConfiguration()->setApiKey('X-THIRDWATCH-API-KEY', $thirdwatchKey);

        $customer = Mage::getSingleton('customer/session')->getCustomer();
        $cartData = array();
        $customerData = Mage::getModel('customer/customer')->load($customer->getId());
        $session = Mage::getSingleton('core/session');
        $SID=$session->getEncryptedSessionId();

        try{
            $currentDate = Varien_Date::now();
            $currentTimestamp = Varien_Date::toTimestamp($currentDate);
            $remoteAddress = Mage::helper('core/http')->getRemoteAddr();

            $cartData['_user_id'] = (string) $customerData->getId();
            $cartData['_session_id'] = (string) $SID;
            $cartData['_device_ip'] = (string) $remoteAddress;
            $cartData['_origin_timestamp'] = (string) $currentTimestamp . '000';
            $cartData['_item'] = $this->getLineItemData($item);
            $api_instance = new \ai\thirdwatch\Api\AddToCartApi();
            $body = new \ai\thirdwatch\Model\AddToCart($cartData);
        }
        catch (Exception $e){
            Mage::helper('mitra/log')->log($e->getMessage());
        }

        try {
            $api_instance->addToCart($body);
        } catch (Exception $e) {
            Mage::helper('mitra/log')->log($e->getMessage());
        }
    }

    public function removeCart($item){
        $helper = Mage::helper('mitra');
        $thirdwatchKey = $helper->getKey();
        \ai\thirdwatch\Configuration::getDefaultConfiguration()->setApiKey('X-THIRDWATCH-API-KEY', $thirdwatchKey);

        $customer = Mage::getSingleton('customer/session')->getCustomer();
        $cartData = array();
        $customerData = Mage::getModel('customer/customer')->load($customer->getId());
        $session = Mage::getSingleton('core/session');
        $SID=$session->getEncryptedSessionId();

        try{
            $currentDate = Varien_Date::now();
            $currentTimestamp = Varien_Date::toTimestamp($currentDate);
            $remoteAddress = Mage::helper('core/http')->getRemoteAddr();

            $cartData['_user_id'] = (string) $customerData->getId();
            $cartData['_session_id'] = (string) $SID;
            $cartData['_device_ip'] = (string) $remoteAddress;
            $cartData['_origin_timestamp'] = (string) $currentTimestamp . '000';

            $cartData['_item'] = $this->getLineItemData($item);

            $api_instance = new \ai\thirdwatch\Api\RemoveFromCartApi();
            $body = new \ai\thirdwatch\Model\RemoveFromCart($cartData);
        }
        catch (Exception $e){
            Mage::helper('mitra/log')->log($e->getMessage());
        }

        try {
            $result = $api_instance->removeFromCart($body);
        } catch (Exception $e) {
            Mage::helper('mitra/log')->log($e->getMessage());
        }
    }

    private function _getCustomerObject($customer_id) {
        if(!isset($this->_customer[$customer_id])) {
            $collection = Mage::getModel('customer/customer')->getCollection();
            $collection->addAttributeToFilter('entity_id', $customer_id);
            $this->_customer[$customer_id] = $collection->getFirstItem();
        }

        return $this->_customer[$customer_id];
    }

    private function getLineItems($model)
    {
        $lineItems = array();
        foreach ($model->getAllVisibleItems() as $key => $val) {
            $lineItems[] = $this->getOrderItemData($val);
        }
        return $lineItems;
    }

    private function getPaymentDetails($model)
    {
        $order = $this->loadOrderByOrigId($this->getOrderOrigId($model));
        $paymentData = array();

        try
        {
            $payment = $order->getPayment();
            $paymentData['_payment_type'] = (string) $payment->getMethodInstance()->getTitle();
            $paymentData['_amount'] = (string) $order->getGrandTotal();
            $paymentData['_currency_code'] = (string) $order->getOrderCurrencyCode();
            $paymentData['_payment_gateway'] = (string) $payment->getMethodInstance()->getTitle();
        }
        catch (Exception $e) {
            Mage::helper('mitra/log')->log($e->getMessage());
        }

        $paymentJson = new \ai\thirdwatch\Model\PaymentMethod($paymentData);
        return $paymentJson;
    }

    private function loadOrderByOrigId($full_orig_id)
    {
        if (!$full_orig_id) {
            return null;
        }

        $magento_ids = explode("_", $full_orig_id);
        $order_id = $magento_ids[0];
        $increment_id = $magento_ids[1];

        if ($order_id && $increment_id) {
            return Mage::getModel('sales/order')->getCollection()
                ->addFieldToFilter('entity_id', $order_id)
                ->addFieldToFilter('increment_id', $increment_id)
                ->getFirstItem();
        }
        return Mage::getModel('sales/order')->load($order_id);
    }

    private function getOrder($model){
        $orderData = array();
        $customerData = $this->_getCustomerObject($model->getCustomerId());
        $session = Mage::getSingleton('core/session');
        $SID=$session->getEncryptedSessionId();

        try{
            $remoteAddress = Mage::helper('core/http')->getRemoteAddr();

            $orderData['_user_id'] = (string) $customerData->getId();
            $orderData['_session_id'] = (string) $SID;
            $orderData['_device_ip'] = (string) $remoteAddress;
            $orderData['_origin_timestamp'] = (string) Varien_Date::toTimestamp($model->getCreatedAt()) . '000';
            $orderData['_order_id'] = (string) $this->getOrderOrigId($model);
            $orderData['_user_email'] = (string) $model->getCustomerEmail();
            $orderData['_amount'] = (string) $model->getGrandTotal();
            $orderData['_currency_code'] = (string) $model->getOrderCurrencyCode();
            $orderData['_billing_address'] = Mage::helper('mitra/common')->getBillingAddress($model->getBillingAddress());
            $orderData['_shipping_address'] = Mage::helper('mitra/common')->getShippingAddress($model->getShippingAddress());
            $orderData['_items'] = $this->getLineItems($model);
            $orderData['_payment_methods'] = array($this->getPaymentDetails($model));
        }
        catch (Exception $e){
            Mage::helper('mitra/log')->log($e->getMessage());
        }
        return $orderData;
    }

    public function createOrder($model){
        $helper = Mage::helper('mitra');
        $thirdwatchKey = $helper->getKey();
        \ai\thirdwatch\Configuration::getDefaultConfiguration()->setApiKey('X-THIRDWATCH-API-KEY', $thirdwatchKey);

        try {
            $orderData = $this->getOrder($model);
            $api_instance = new \ai\thirdwatch\Api\CreateOrderApi();
            $body = new \ai\thirdwatch\Model\CreateOrder($orderData);
        }
        catch (Exception $e){
            Mage::helper('mitra/log')->log($e);
        }

        try {
            $api_instance->createOrder($body);
        } catch (Exception $e) {
            Mage::helper('mitra/log')->log($e->getMessage());
        }
    }

    private function getOrderStatus($model){
        $orderData = array();
        $customerData = $this->_getCustomerObject($model->getCustomerId());
        $session = Mage::getSingleton('core/session');
        $SID=$session->getEncryptedSessionId();

        try{
            $orderData['_user_id'] = (string) $customerData->getId();
            $orderData['_session_id'] = (string) $SID;
            $orderData['_order_id'] = (string) $this->getOrderOrigId($model);
            $orderData['_order_status'] = (string) $model->getState();;
            $orderData['_reason'] = '';
            $orderData['_shipping_cost'] = '';
            $orderData['_tracking_number'] = '';
            $orderData['_tracking_method'] = '';
        }
        catch (Exception $e){
            Mage::helper('mitra/log')->log($e->getMessage());
        }
        return $orderData;
    }

    public function updateOrderStatus($model){
        $helper = Mage::helper('mitra');
        $thirdwatchKey = $helper->getKey();
        \ai\thirdwatch\Configuration::getDefaultConfiguration()->setApiKey('X-THIRDWATCH-API-KEY', $thirdwatchKey);

        try {
            $orderData = $this->getOrderStatus($model);
            $api_instance = new \ai\thirdwatch\Api\OrderStatusApi();
            $body = new \ai\thirdwatch\Model\OrderStatus($orderData);
        }
        catch (Exception $e){
            Mage::helper('mitra/log')->log($e);
        }

        try {
            $api_instance->orderStatus($body);
        } catch (Exception $e) {
            Mage::helper('mitra/log')->log($e->getMessage());
        }
    }

    private function getTransaction($model, $txnType)
    {
        $orderData = array();
        $customerData = $this->_getCustomerObject($model->getCustomerId());
        $session = Mage::getSingleton('core/session');
        $SID = $session->getEncryptedSessionId();
        $txnId = '';

        try {
            $payment = $model->getPayment();
            $txnId = $payment->getLastTransId();
        }catch (Exception $e){
            Mage::helper('mitra/log')->log($e->getMessage());
        }

        try {
            $remoteAddress = Mage::helper('core/http')->getRemoteAddr();

            $orderData['_user_id'] = (string)$customerData->getId();
            $orderData['_session_id'] = (string)$SID;
            $orderData['_device_ip'] = (string)$remoteAddress;
            $orderData['_origin_timestamp'] = (string)Varien_Date::toTimestamp($model->getCreatedAt()) . '000';
            $orderData['_order_id'] = (string)$this->getOrderOrigId($model);
            $orderData['_user_email'] = (string)$model->getCustomerEmail();
            $orderData['_amount'] = (string)$model->getGrandTotal();
            $orderData['_currency_code'] = (string)$model->getOrderCurrencyCode();
            $orderData['_billing_address'] = Mage::helper('mitra/common')->getBillingAddress($model->getBillingAddress());
            $orderData['_shipping_address'] = Mage::helper('mitra/common')->getShippingAddress($model->getShippingAddress());
            $orderData['_items'] = $this->getLineItems($model);
            $orderData['_payment_method'] = $this->getPaymentDetails($model);

            if ($txnId){
                $orderData['_transaction_id'] = $txnId;
            }

            $orderData['_transaction_type'] = $txnType;
            $orderData['_transaction_status'] = '_success';
        } catch (Exception $e) {
            Mage::helper('mitra/log')->log($e->getMessage());
        }
        return $orderData;

    }

    public function createTransaction($model, $txnType){
        $helper = Mage::helper('mitra');
        $thirdwatchKey = $helper->getKey();
        \ai\thirdwatch\Configuration::getDefaultConfiguration()->setApiKey('X-THIRDWATCH-API-KEY', $thirdwatchKey);

        try {
            $orderData = $this->getTransaction($model, $txnType);
            Mage::helper('mitra/log')->log($orderData);
            $api_instance = new \ai\thirdwatch\Api\TransactionApi();
            $body = new \ai\thirdwatch\Model\Transaction($orderData);
        }
        catch (Exception $e){
            Mage::helper('mitra/log')->log($e->getMessage());
        }

        try {
            $api_instance->transaction($body);
        } catch (Exception $e) {
            Mage::helper('mitra/log')->log($e->getMessage());
        }
    }
}