<?php

/*
SSLCOMMERZ Payment Controller
By: SSL WIRELESS.
www.sslwireless.com
*/

class Sslwireless_Sslcommerz_PaymentController extends Mage_Core_Controller_Front_Action {
	// The redirect action is triggered when someone places an order
	public function redirectAction() {
		$this->loadLayout();
        $block = $this->getLayout()->createBlock('Mage_Core_Block_Template','sslcommerz',array('template' => 'sslcommerz/redirect.phtml'));
		$this->getLayout()->getBlock('content')->append($block);
        $this->renderLayout();
	}
	
	// The response action is triggered when your gateway sends back a response after processing the customer's payment
	public function responseAction() {

		$validUrl = array('1'=>'https://sandbox.sslcommerz.com/validator/api/validationserverAPI.php', '2'=>'https://securepay.sslcommerz.com/validator/api/validationserverAPI.php');

		if($this->getRequest()->isPost()) {
			
			/*
			/* Your gateway's code to make sure the reponse you
			/* just got is from the gatway and not from some weirdo.
			/* This generally has some checksum or other checks,
			/* and is provided by the gateway.
			/* For now, we assume that the gateway's response is valid
			*/
			

			$gateWayResponse = $this->getRequest()->getParams();
			
           
			$orderId = Mage::getSingleton('checkout/session')->getLastRealOrderId();
			
			if($gateWayResponse['status']=='VALID') {
                             

            $store_id = urlencode(Mage::getStoreConfig('payment/sslcommerz/marchent'));
			$password = urlencode(Mage::getStoreConfig('payment/sslcommerz/signaturekey'));
			$val_id = urlencode($gateWayResponse['val_id']);
			$risk_level = $gateWayResponse['risk_level'];
			$risk_title = $gateWayResponse['risk_level'];

             

 $requested_url = $validUrl[Mage::getStoreConfig('payment/sslcommerz/marchenturl')].'?val_id='.$val_id.'&store_id='.$store_id.'&store_passwd='.$password;

          
          

		       $handle=curl_init(); 
		       curl_setopt($handle, CURLOPT_URL,$requested_url);
		       curl_setopt($handle, CURLOPT_RETURNTRANSFER,true); 
		       curl_setopt($handle, CURLOPT_SSL_VERIFYHOST,false); 
		       curl_setopt($handle, CURLOPT_SSL_VERIFYPEER,false); 
		       $result=curl_exec($handle); 

		       $code=curl_getinfo($handle, CURLINFO_HTTP_CODE);

       
      

      
               
				// Payment was successful, so update the order's state, send order email and move to the success page

				$order = Mage::getModel('sales/order');
				$order->loadByIncrementId($orderId);
				if($risk_level=='0'){

				$order->setState(Mage_Sales_Model_Order::STATE_PROCESSING, true, 'Gateway has authorized the payment.');

				 }
				else{

                $order->setState(Mage_Sales_Model_Order::STATE_HOLDED, true, $risk_title);

				}

				$order->sendNewOrderEmail();
				$order->setEmailSent(true);
				
				$order->save();
			
				Mage::getSingleton('checkout/session')->unsQuoteId();
				
				Mage_Core_Controller_Varien_Action::_redirect('checkout/onepage/success', array('_secure'=>true));
			}
			else {
				// There is a problem in the response we got
				$this->cancelAction();
				Mage_Core_Controller_Varien_Action::_redirect('checkout/onepage/failure', array('_secure'=>true));
			}
		}
		else
			Mage_Core_Controller_Varien_Action::_redirect('');
	}

	public function ipnAction(){
        
        $password = md5(Mage::getStoreConfig('payment/sslcommerz/signaturekey'));
        $helperData = Mage::helper('sslcommerz'); 
        $result = "No Result";
      if($this->getRequest()->isPost()){

      	$gatwayIpnData = $this->getRequest()->getParams();
if($helperData->ipn_hash_varify($password, $gatwayIpnData)) {

                   $result = "Hash validation success.";
                }
   else {
            
                    $result = "Hash validation failed.";
          }
      }

        echo $result;
	}
	
	// The cancel action is triggered when an order is to be cancelled
	public function cancelAction() {
		
        if (Mage::getSingleton('checkout/session')->getLastRealOrderId()) {

            $order = Mage::getModel('sales/order')->loadByIncrementId(Mage::getSingleton('checkout/session')->getLastRealOrderId());
            if($order->getId()) {
				// Flag the order as 'cancelled' and save it
				$order->cancel()->setState(Mage_Sales_Model_Order::STATE_CANCELED, true, 'Gateway has declined the payment.')->save();
			}
        }
        Mage_Core_Controller_Varien_Action::_redirect('checkout/onepage/failure', array('_secure'=>true));
	}
}
