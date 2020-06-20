<?php

namespace Sslwireless\Sslcommerz\Block\Notification;

/**
 * Abstract class for Cash On Delivery and Bank Transfer payment method form
 */
use \Magento\Framework\View\Element\Template;


class Notification extends Template
{
    protected $Config;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * @var \Magento\Sales\Model\OrderFactory
     */
    protected $_orderFactory;

    /**
     * @var \Magento\Sales\Model\Order\Config
     */
    protected $_orderConfig;

    /**
     * @var \Magento\Framework\App\Http\Context
     */
    protected $httpContext;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \Magento\Sales\Model\Order\Config $orderConfig,
        \Magento\Framework\App\Http\Context $httpContext,
        \Sslwireless\Sslcommerz\Model\Sslcommerz $paymentConfig,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_checkoutSession = $checkoutSession;
        $this->_customerSession = $customerSession;
        $this->_orderFactory = $orderFactory;
        $this->_orderConfig = $orderConfig;
        $this->_isScopePrivate = true;
        $this->httpContext = $httpContext;
        $this->Config = $paymentConfig;
    }

   


    protected $_template = 'success/success.phtml';

    /**
     * Get instructions text from config
     *
     * @return null|string
     */
    public function getSuccessMsg()
    {
        return $this->Config->getSuccessMsg();
    }

    // public function getAmount()
    // {   $orderId = $this->_checkoutSession->getLastOrderId(); 
    //     if ($orderId) 
    //     {
    //         $incrementId = $this->_checkoutSession->getLastRealOrderId();
    //         return $this->Config->getAmount($incrementId);
    //     }
    // }

    // public function getPostData()
    // {
    //     $orderId = $this->_checkoutSession->getLastOrderId(); 
    //     if ($orderId) 
    //     {
    //         $incrementId = $this->_checkoutSession->getLastRealOrderId();
    //         return $this->Config->getPostData($incrementId);
    //     }
    // }
}
