<?php
class Sslwireless_Sslcommerz_Model_Standard extends Mage_Payment_Model_Method_Abstract {
	protected $_code = 'sslcommerz';
	
	protected $_isInitializeNeeded      = true;
	protected $_canUseInternal          = true;
	protected $_canUseForMultishipping  = false;
	
	public function getOrderPlaceRedirectUrl() {
		return Mage::getUrl('sslcommerz/payment/redirect', array('_secure' => true));
	}
}
?>