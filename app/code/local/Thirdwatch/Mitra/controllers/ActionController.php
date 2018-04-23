<?php

class Thirdwatch_Mitra_ActionController extends Mage_Core_Controller_Front_Action
{
    public function getresponseAction()
    {
        Mage::helper('mitra/log')->log("Action Controller");

        $request = $this->getRequest();
        $response = $this->getResponse();

        $logger = Mage::helper('mitra/log');
        $statusCode = 200;
        $orderId = null;
        $msg = null;

        try {
            $body = $request->getRawBody();
            $jsonBody = json_decode($body);

            if (array_key_exists('test', $jsonBody)){
                $response->setHttpResponseCode($statusCode);
                $response->setHeader('Content-Type', 'application/json');
                $response->setBody('{}');
                $logger->log("Action URL Successfully Tested");
                return ;
            }

            if (!array_key_exists('order_id', $jsonBody))
                Mage::throwException('Order Id doesnot exists.');

            $orderId = $jsonBody->{'order_id'};
            $actionType = $jsonBody->{'action_type'};
            $comment = $jsonBody->{'action_message'};

            Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
            $order = $this->loadOrderByOrigId($orderId);

            if (!$order || !$order->getId()) {
                $statusCode = 400;
                $msg = 'Could not find order to update.';
            } else {
                try {
                    if ($actionType === "approved"){
                        $order->setState(Mage_Sales_Model_Order::STATE_PROCESSING, 'thirdwatch_approved');
                        if (!empty($comment) and strtolower($comment) != "none"){
                            $order->addStatusHistoryComment($comment);
                        }
                        $order->save();
                    }
                    else{
                        $order->setState(Mage_Sales_Model_Order::STATE_HOLDED, 'thirdwatch_declined');
                        if (!empty($comment) and strtolower($comment) != "none"){
                            $order->addStatusHistoryComment($comment);
                        }
                        $order->save();
                    }
                    $statusCode = 200;
                    $msg = 'Action-Update event triggered.';
                } catch (PDOException $e) {
                    $exceptionMessage = 'SQLSTATE[40001]: Serialization '
                        . 'failure: 1213 Deadlock found when trying to get '
                        . 'lock; try restarting transaction';

                    if ($e->getMessage() === $exceptionMessage) {
                        throw new Exception('Deadlock exception handled.');
                    } else {
                        throw $e;
                    }
                }
            }
        } catch (Exception $e) {
            $logger->log("ERROR: while processing notification for order $orderId");
            $logger->logException($e);
            $statusCode = 500;
            $msg = "Internal Error";
        }

        $response->setHttpResponseCode($statusCode);
        $response->setHeader('Content-Type', 'application/json');
        $response->setBody('{ "order" : { "id" : "' . $orderId . '", "description" : "' . $msg . '" } }');
    }

    private function loadOrderByOrigId($full_orig_id)
    {
        if (!$full_orig_id) {
            return null;
        }

        return Mage::getModel('sales/order')->loadByIncrementId($full_orig_id);

    }
}