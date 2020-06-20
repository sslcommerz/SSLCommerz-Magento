<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Sslwireless\Sslcommerz\Controller\Payment;
use Magento\Framework\Controller\ResultFactory;

/**
 * Responsible for loading page content.
 *
 * This is a basic controller that only loads the corresponding layout file. It may duplicate other such
 * controllers, and thus it is considered tech debt. This code duplication will be resolved in future releases.
 */
class Test extends \Magento\Framework\App\Action\Action
{
    /** @var \Magento\Framework\View\Result\PageFactory  */
    protected $resultPageFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }
    /**
     * Load the page defined in view/frontend/layout/samplenewpage_index_index.xml
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {   //load model
        /* @var $paymentMethod \Magento\Authorizenet\Model\DirectPost */
        $paymentMethod = $this->_objectManager->create('Sslwireless\Sslcommerz\Model\Sslcommerz');
        
        // $data = $this->getRequest()->getPostValue();
        // $all = $paymentMethod->ipnAction($data);

        //get request data
        // $data = $paymentMethod->getCusMail();testfunc
        // $data = $paymentMethod->testfunc();
        // $ipndata['amount'] = "1164.59";
        // $ipndata['bank_tran_id'] = "1909231037421XdqSd3nfgEi9DB";
        // $ipndata['card_brand'] = "MOBILEBANKING";
        // $ipndata['card_issuer'] = "BKash Mobile Banking";
        // $ipndata['card_issuer_country'] = "Bangladesh";
        // $ipndata['card_issuer_country_code'] = "BD";
        // $ipndata['card_no'] = "";
        // $ipndata['card_type'] = "BKASH-BKash";
        // $ipndata['status'] = "VALID";
        // $ipndata['store_amount'] = "1135.47525";
        // $ipndata['store_id'] = "testbox";
        // $ipndata['tran_date'] = "2019-09-23 10:37:29";
        // $ipndata['tran_id'] = "000000071";
        // $ipndata['val_id'] = "190923103743MYZwxa3gtBFIQA5";
        // $ipndata['verify_sign'] = "8070c0cefed9e629b01100d8a92afda2";
        // $ipndata['verify_key'] = "amount,bank_tran_id,base_fair,card_brand,card_issuer,card_issuer_country,card_issuer_country_code,card_no,card_type,currency,currency_amount,currency_rate,currency_type,risk_level,risk_title,status,store_amount,store_id,tran_date,tran_id,val_id,value_a,value_b,value_c,value_d";
        // $data = $paymentMethod->ipnAction($ipndata);

        // foreach ($data as $item)
        // {
        //   echo $item->getId()."<br>";
        //   echo $item->getProductType()."<br>";
        //   echo $item->getQtyOrdered()."<br>";
        //   echo $item->getPrice()."<br>";
        //   echo $item->getName()."<br>";
        // }
        // $test = $paymentMethod->getSslOrederStatus("000000071");
        // echo "<pre>";
        // print_r($test);
       
        
        // $mail = $this->_objectManager->create('Sslwireless\Sslcommerz\Controller\Payment\Sendemail');
        // $mail->SuccessEmail();
        // $mail->FailEmail();
        // $mail->CancelEmail();

    }
}
