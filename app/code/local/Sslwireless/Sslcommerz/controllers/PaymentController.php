<?php

/*
SSLCOMMERZ Payment Controller
By: SSL WIRELESS.
www.sslwireless.com
*/

class Sslwireless_Sslcommerz_PaymentController extends Mage_Core_Controller_Front_Action
{
    // The redirect action is triggered when someone places an order
    public function redirectAction()
    {
        $this->loadLayout();
        $block = $this->getLayout()->createBlock('Mage_Core_Block_Template', 'sslcommerz', array(
            'template' => 'sslcommerz/redirect.phtml'
        ));
        $this->getLayout()->getBlock('content')->append($block);
        $this->renderLayout();
    }
    
    // The response action is triggered when your gateway sends back a response after processing the customer's payment
    public function responseAction()
    {
        $validUrl = array(
            '1' => 'https://sandbox.sslcommerz.com/validator/api/validationserverAPI.php',
            '2' => 'https://securepay.sslcommerz.com/validator/api/validationserverAPI.php'
        );
        
        if ($this->getRequest()->isPost()) {
            
            /*
            /* Your gateway's code to make sure the reponse you
            /* just got is from the gatway and not from some weirdo.
            /* This generally has some checksum or other checks,
            /* and is provided by the gateway.
            /* For now, we assume that the gateway's response is valid
            */
            
            $gateWayResponse = $this->getRequest()->getParams();

            $orderId = Mage::getSingleton('checkout/session')->getLastRealOrderId();
            
            if ($gateWayResponse['status'] == 'VALID' || $gateWayResponse['status'] == 'VALIDATED') 
            {
                $store_id   = urlencode(Mage::getStoreConfig('payment/sslcommerz/marchent'));
                $password   = urlencode(Mage::getStoreConfig('payment/sslcommerz/signaturekey'));
                $val_id     = urlencode($gateWayResponse['val_id']);
                $risk_level = $gateWayResponse['risk_level'];
                $risk_title = $gateWayResponse['risk_level'];

                $requested_url = $validUrl[Mage::getStoreConfig('payment/sslcommerz/marchenturl')] . '?val_id=' . $val_id . '&store_id=' . $store_id . '&store_passwd=' . $password;

                $handle = curl_init();
                curl_setopt($handle, CURLOPT_URL, $requested_url);
                curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
                $result = curl_exec($handle);
                
                $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

                // Payment was successful, so update the order's state, send order email and move to the success page
                if($code == 200 && !( curl_errno($handle)))
				{
					$result = json_decode($result);

					# TRANSACTION INFO
					$status = $result->status;
					$tran_date = $result->tran_date;
					$tran_id = $result->tran_id;
					$val_id = $result->val_id;

					$order = Mage::getModel('sales/order');
	                $order->loadByIncrementId($orderId);

	                if($order->getStatus() == "pending")
	                {
	                	if ($result != "" && ($status == 'VALID' || $status == 'VALIDATED')) {
	                    $order->setState(Mage_Sales_Model_Order::STATE_PROCESSING, true, 'Gateway has authorized the payment.');
		                } 
		                else {
		                    $order->setState(Mage_Sales_Model_Order::STATE_HOLDED, true, $risk_title);
		                }
		                
		                $order->sendNewOrderEmail();
		                $order->setEmailSent(true);
		                $order->save();
		                
		                Mage::getSingleton('checkout/session')->unsQuoteId();
		                
		                Mage_Core_Controller_Varien_Action::_redirect('checkout/onepage/success', array(
		                    '_secure' => true
		                ));
	                }
	                else if($result != "" && ($status == 'VALID' || $status == 'VALIDATED') && ($order->getStatus() == "processing"))
	                {
	                	Mage::getSingleton('checkout/session')->unsQuoteId();
		                Mage_Core_Controller_Varien_Action::_redirect('checkout/onepage/success', array(
		                    '_secure' => true
		                ));
	                }
				} 
				else 
				{
					echo "Failed to connect with SSLCOMMERZ";
				}
            } 
            else 
            {
                // There is a problem in the response we got
                $this->cancelAction();
                Mage_Core_Controller_Varien_Action::_redirect('checkout/onepage/failure', array(
                    '_secure' => true
                ));
            }
        } 
        else
        {
            Mage_Core_Controller_Varien_Action::_redirect('');
        }
    }
    
    public function ipnAction()
    {
    	$validUrl = array(
            '1' => 'https://sandbox.sslcommerz.com/validator/api/validationserverAPI.php',
            '2' => 'https://securepay.sslcommerz.com/validator/api/validationserverAPI.php'
        );
        if ($this->getRequest()->isPost()) 
        {    
            $gateWayResponse = $this->getRequest()->getParams();

            // $orderId = Mage::getSingleton('checkout/session')->getLastRealOrderId();
            $orderId = $gateWayResponse['tran_id'];
            $order = Mage::getModel('sales/order');
	        $order->loadByIncrementId($orderId);

	        $store_id   = urlencode(Mage::getStoreConfig('payment/sslcommerz/marchent'));
            $password   = urlencode(Mage::getStoreConfig('payment/sslcommerz/signaturekey'));
            
            if ($gateWayResponse['status'] == 'VALID' || $gateWayResponse['status'] == 'VALIDATED') 
            {
                $val_id     = $gateWayResponse['val_id'];

                $requested_url = $validUrl[Mage::getStoreConfig('payment/sslcommerz/marchenturl')] . '?val_id=' . $val_id . '&store_id=' . $store_id . '&store_passwd=' . $password;

                $handle = curl_init();
                curl_setopt($handle, CURLOPT_URL, $requested_url);
                curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
                $result = curl_exec($handle);
                
                $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                if($code == 200 && !( curl_errno($handle)))
				{
					$result = json_decode($result);

					# TRANSACTION INFO
					$status = $result->status;
					$tran_date = $result->tran_date;
					$tran_id = $result->tran_id;
					$val_id = $result->val_id;

					$order = Mage::getModel('sales/order');
	                $order->loadByIncrementId($orderId);

	                if($order->getStatus() == "pending")
	                {
	                	if ($result != "" && ($status == 'VALID' || $status == 'VALIDATED')) {
	                    $order->setState(Mage_Sales_Model_Order::STATE_PROCESSING, true, 'Gateway has authorized the payment.');
		                } 
		                else {
		                    $order->setState(Mage_Sales_Model_Order::STATE_HOLDED, true, $risk_title);
		                }
		                
		                $order->sendNewOrderEmail();
		                $order->setEmailSent(true);
		                
		                $order->save();
		                
		                Mage::getSingleton('checkout/session')->unsQuoteId();
		                $resp = "Order Validated By IPN";
		            }
				} 
				else 
				{
					$resp = "Failed to connect with SSLCOMMERZ";
				}
            } 
            else if ($gateWayResponse['status'] == 'FAILED') 
            {
            	if($order->getStatus() == "pending")
	            {
            		if (Mage::getSingleton('checkout/session')->getLastRealOrderId()) 
            		{
			            $order = Mage::getModel('sales/order')->loadByIncrementId(Mage::getSingleton('checkout/session')->getLastRealOrderId());
			            if ($order->getId()) {
			                // Flag the order as 'cancelled' and save it
			                $order->cancel()->setState(Mage_Sales_Model_Order::STATE_CANCELED, true, 'Gateway has declined the payment.')->save();
			                $resp = "Order Failed By IPN";
			            }
			        }
            	}
            }
            else if ($gateWayResponse['status'] == 'CANCELLED')
            {
            	if($order->getStatus() == "pending")
	            {
            		if (Mage::getSingleton('checkout/session')->getLastRealOrderId()) 
            		{
			            $order = Mage::getModel('sales/order')->loadByIncrementId(Mage::getSingleton('checkout/session')->getLastRealOrderId());
			            if ($order->getId()) {
			                // Flag the order as 'cancelled' and save it
			                $order->cancel()->setState(Mage_Sales_Model_Order::STATE_CANCELED, true, 'Gateway has declined the payment.')->save();
			                $resp = "Order cancelled By IPN";
			            }
			        }
            	}
            }
        }
        else
        {
        	$resp = "No Ipn Request Found!";
        	echo "<span align='center'><h2>IPN only accept POST request!</h2><p>Remember, We have set an IPN URL in first step so that your server can listen at the right moment when payment is done at Bank End. So, It is important to validate the transaction notification to maintain security and standard.As IPN URL already set in script. All the payment notification will reach through IPN prior to user return back. So it needs validation for amount and transaction properly.</p></span>";
        }
        $ipn_log = fopen("SSLCOM_IPN_LOG.txt", "a+") or die("Unable to open file!");
        $ipn_result = array('Transaction ID:' => $gateWayResponse['tran_id'],'Date Time:' => $gateWayResponse['tran_date'],'Val ID:' => $gateWayResponse['val_id'],'Amount:' => $gateWayResponse['amount'],'Card Type:' => $gateWayResponse['card_type'],'Card Type:' => $gateWayResponse['card_type'],'Currency:' => $gateWayResponse['currency'],'Card Issuer:' => $gateWayResponse['card_issuer'],'Store ID:' => $gateWayResponse['store_id'],'Status:' => $gateWayResponse['status'],'IPN Response:'=> $resp);
        fwrite($ipn_log, json_encode($ipn_result).PHP_EOL);
        fclose($ipn_log);
    }
    
    // The cancel action is triggered when an order is to be cancelled
    public function cancelAction()
    {
        if (Mage::getSingleton('checkout/session')->getLastRealOrderId()) {
            
            $order = Mage::getModel('sales/order')->loadByIncrementId(Mage::getSingleton('checkout/session')->getLastRealOrderId());
            if ($order->getId()) {
                // Flag the order as 'cancelled' and save it
                $order->cancel()->setState(Mage_Sales_Model_Order::STATE_CANCELED, true, 'Gateway has declined the payment.')->save();
            }
        }
        Mage_Core_Controller_Varien_Action::_redirect('checkout/onepage/failure', array(
            '_secure' => true
        ));
    }
}