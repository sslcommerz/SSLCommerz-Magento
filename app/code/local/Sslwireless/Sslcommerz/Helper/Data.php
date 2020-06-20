<?php
class Sslwireless_Sslcommerz_Helper_Data extends Mage_Core_Helper_Abstract
{
   function sslcommerz_hash_key($store_passwd="", $parameters=array()) {
	
			$return_key = array(
				"verify_sign"	=>	"",
				"verify_key"	=>	""
			);
			if(!empty($parameters)) {
				# ADD THE PASSWORD
		
				$parameters['store_passwd'] = md5($store_passwd);
		
				# SORTING THE ARRAY KEY
		
				ksort($parameters);	
		
				# CREATE HASH DATA
			
				$hash_string="";
				$verify_key = "";	# VARIFY SIGN
				foreach($parameters as $key=>$value) {
					$hash_string .= $key.'='.($value).'&'; 
					if($key!='store_passwd') {
						$verify_key .= "{$key},";
					}
				}
				$hash_string = rtrim($hash_string,'&');	
				$verify_key = rtrim($verify_key,',');
		
				# THAN MD5 TO VALIDATE THE DATA
		
				$verify_sign = md5($hash_string);
				$return_key['verify_sign'] = $verify_sign;
				$return_key['verify_key'] = $verify_key;
			}
			return $return_key;
		}

function ipn_hash_varify($store_passwd="", $data="") {
if(isset($data) && isset($data['verify_sign']) && isset($data['verify_key'])) {
# NEW ARRAY DECLARED TO TAKE VALUE OF ALL POST
$pre_define_key = explode(',', $data['verify_key']);
$new_data = array();
if(!empty($pre_define_key )) {
foreach($pre_define_key as $value) {
if(isset($data[$value])) {
$new_data[$value] = ($data[$value]);
}
}
}
# ADD MD5 OF STORE PASSWORD
$new_data['store_passwd'] = ($store_passwd);
# SORT THE KEY AS BEFORE
ksort($new_data);
$hash_string="";
foreach($new_data as $key=>$value) { $hash_string .= $key.'='.($value).'&'; }
$hash_string = rtrim($hash_string,'&');
if(md5($hash_string) == $data['verify_sign']) {
return true;
} else {
      return false;
}
} else return false;
}
		/// END
}
