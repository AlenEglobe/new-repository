<?php

namespace FirstVendor\LogModule\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\Request\Http;

class Log404 implements ObserverInterface
{
    private $logger;
    private $request;
    private $resource;
    protected $counter;

    public function __construct(LoggerInterface $logger, Http $request, ResourceConnection $resource)
    {
        $this->logger = $logger;
        $this->resource = $resource;
        $this->counter  = 0;
    }

    public function execute(Observer $observer)

    {
        $response = $observer->getEvent()->getResponse();
        if ($response && $response->getHttpResponseCode() == 404) {

            $this->counter++;
            $writer  = new \Zend_Log_Writer_Stream(BP . '/var/log/custom.log');

            $url = $this->getCurrentUrl();
            $zendLogger = new \Zend_Log();
            $zendLogger->addWriter($writer);


            // Log the 404 error
            $zendLogger->err('404 Page Not Found: ' . $url . " " . "Count:" . $this->counter);
        }
    }

    protected function getCurrentUrl()
    {
        return isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
    }
}
