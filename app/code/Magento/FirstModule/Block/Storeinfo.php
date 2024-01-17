<?php

namespace Magento\FirstModule\Block;

use Magento\Framework\View\Element\Template;

class StoreInfo extends Template
{
    protected $_storeManager;

    public function __construct(
        Template\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_storeManager = $storeManager;
    }

    public function getStoreInformation()
    {

        $store = $this->_storeManager->getStore();
        $storeInfo = [
            'Store ID' => $store->getId(),
            'Store Name' => $store->getName(),
            'Store Code' => $store->getCode(),
            // 'Store URL' => $store->getBaseUrl(),
            // Add more information as needed
        ];
        return $storeInfo;
    }
}
