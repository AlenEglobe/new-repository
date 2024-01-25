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
            $this->logToDatabase($url, $this->counter);



            // Log the 404 error
            $zendLogger->err('404 Page Not Found: ' . $url . " " . "Count:" . $this->counter);
        }
    }

    protected function logToDatabase($url, $counter)
    {
        $connection = $this->resource->getConnection();
        $tableName = $this->resource->getTableName('logtable');

        $data = [
            'url' => $url,
            'count' => $counter
        ];

        $current_count = $this->getCurrentCount();


        if ($current_count ==  0) {
            $connection->insert($tableName, $data);
        } else {
            $current_count++;
            $data_count = ['count' => $current_count];
            $where = ['url = ?' => $url];
            $connection->update($tableName, $data_count, $where);
        }
    }

    protected function getCurrentCount()
    {
        $connection = $this->resource->getConnection();
        $tableName = $this->resource->getTableName('logtable');

        $select = $connection->select()->from($tableName, 'count')->where('url = ?', $this->getCurrentUrl());
        $count = $connection->fetchOne($select);
        return  $count ? (int)$count : '';
    }

    protected function getCurrentUrl()
    {
        return isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
    }
}
