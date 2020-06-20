<?php
	/***********
	* © SSLCommerz 2017 
	* Author : SSLCommerz
	* Developed by : Prabal Mallick
	* Email: prabal.mallick@sslwireless.com
	***********/
	
	use Magento\Framework\App\Bootstrap;

	require __DIR__ . '/app/bootstrap.php';

	$bootstrap = Bootstrap::create(BP, $_SERVER);

	$obj = $bootstrap->getObjectManager();

	$state = $obj->get('Magento\Framework\App\State');
	$state->setAreaCode('frontend');
	$k[0]='bin/magento';
	$k[1]='setup:upgrade'; // write your proper command like setup:upgrade,cache:enable etc...
	$_SERVER['argv']=$k;
	try {
	    $handler = new \Magento\Framework\App\ErrorHandler();
	    set_error_handler([$handler, 'handler']);
	    $application = new Magento\Framework\Console\Cli('Magento CLI');
	    $application->run();
	} catch (\Exception $e) {
	    while ($e) {
	        echo $e->getMessage();
	        echo $e->getTraceAsString();
	        echo "\n\n";
	        $e = $e->getPrevious();
	    }
	}
?>