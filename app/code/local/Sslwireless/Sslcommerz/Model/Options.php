<?php
class Sslwireless_Sslcommerz_Model_Options {
public function toOptionArray()
   {
       $themes = array(
           array('value' => '1', 'label' => 'Test URL'),
           array('value' => '2', 'label' => 'Live URL')
           
       );
 
       return $themes;
   }
}
?>