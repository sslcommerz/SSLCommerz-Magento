<?php
 
namespace Sslwireless\Sslcommerz\Controller\Payment;
 
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
 
class Sendemail extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $_request;
    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $_transportBuilder;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;
 
    public function __construct(
        \Magento\Framework\App\Action\Context $context
        , \Magento\Framework\App\Request\Http $request
        , \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
        , \Magento\Store\Model\StoreManagerInterface $storeManager
    )
    {
        $this->_request = $request;
        $this->_transportBuilder = $transportBuilder;
        $this->_storeManager = $storeManager;
        parent::__construct($context);
    }
 
    public function execute()
    {
        $this->SuccessEmail();
    }
    
    public function SuccessEmail()
    {
        $paymentMethod = $this->_objectManager->create('Sslwireless\Sslcommerz\Model\Sslcommerz');
        $data = $paymentMethod->getCusMail();
        $storeactivity = $this->_storeManager->getStore()->isActive();
        
        if($storeactivity == "1")
        {
            $store = $this->_storeManager->getStore()->getId();
            $templateVars = array(
                'store_name' => $this->_storeManager->getStore()->getName(),
                'order_id' => $data['order_id'],
                'customer_name' => $data['cus_name'],
                'amount'   => $data['total_amount'],
                'title'     => $data['title'],
                'full_name'     => $data['full_name'],
                'country'     => $data['country'],
                'street'     => $data['street'][0],
                'region'     => $data['region'],
                'city'     => $data['city'],
                'telephone'     => $data['telephone']
                );
            $transport = $this->_transportBuilder->setTemplateIdentifier    ('sslcommerz_success_template')
            ->setTemplateOptions(['area' => 'frontend', 'store' => $store])
            ->setTemplateVars($templateVars)
            ->setFrom('sales')
            ->addTo($data['cus_email'])
            ->getTransport();
            
            return $transport->sendMessage();
        }
    }
    
    public function FailEmail()
    {
        $paymentMethod = $this->_objectManager->create('Sslwireless\Sslcommerz\Model\Sslcommerz');
        $data = $paymentMethod->getCusMail();
        $storeactivity = $this->_storeManager->getStore()->isActive();
        
        if($storeactivity == "1")
        {
            $store = $this->_storeManager->getStore()->getId();
            $templateVars = array(
                'store_name' => $this->_storeManager->getStore()->getName(),
                'order_id' => $data['order_id'],
                'customer_name' => $data['cus_name'],
                'amount'   => $data['total_amount'],
                'title'     => $data['title'],
                'full_name'     => $data['full_name'],
                'country'     => $data['country'],
                'street'     => $data['street'][0],
                'region'     => $data['region'],
                'city'     => $data['city'],
                'telephone'     => $data['telephone']
                );
            $transport = $this->_transportBuilder->setTemplateIdentifier    ('sslcommerz_fail_template')
            ->setTemplateOptions(['area' => 'frontend', 'store' => $store])
            ->setTemplateVars($templateVars)
            ->setFrom('sales')
            ->addTo($data['cus_email'])
            ->getTransport();
            
            return $transport->sendMessage();
        }
    }
    
    public function CancelEmail()
    {
        $paymentMethod = $this->_objectManager->create('Sslwireless\Sslcommerz\Model\Sslcommerz');
        $data = $paymentMethod->getCusMail();
        $storeactivity = $this->_storeManager->getStore()->isActive();
        
        if($storeactivity == "1")
        {
            $store = $this->_storeManager->getStore()->getId();
            $templateVars = array(
                'store_name' => $this->_storeManager->getStore()->getName(),
                'order_id' => $data['order_id'],
                'customer_name' => $data['cus_name'],
                'amount'   => $data['total_amount'],
                'title'     => $data['title'],
                'full_name'     => $data['full_name'],
                'country'     => $data['country'],
                'street'     => $data['street'][0],
                'region'     => $data['region'],
                'city'     => $data['city'],
                'telephone'     => $data['telephone']
                );
            $transport = $this->_transportBuilder->setTemplateIdentifier    ('sslcommerz_cancel_template')
            ->setTemplateOptions(['area' => 'frontend', 'store' => $store])
            ->setTemplateVars($templateVars)
            ->setFrom('sales')
            ->addTo($data['cus_email'])
            ->getTransport();
            
            return $transport->sendMessage();
        }
    }
}