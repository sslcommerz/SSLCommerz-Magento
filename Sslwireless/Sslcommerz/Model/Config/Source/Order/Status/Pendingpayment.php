<?php

/***********
 * © SSLCommerz 2017 
 * Author : SSLCommerz
 * Developed by : Prabal Mallick
 * Email: prabal.mallick@sslwireless.com
 ***********/

namespace Sslwireless\Sslcommerz\Model\Config\Source\Order\Status;

use Magento\Sales\Model\Order;
use Magento\Sales\Model\Config\Source\Order\Status;

/**
 * Order Status source model
 */
class Pendingpayment extends Status
{
    /**
     * @var string[]
     */
    protected $_stateStatuses = [Order::STATE_PENDING_PAYMENT];
}
