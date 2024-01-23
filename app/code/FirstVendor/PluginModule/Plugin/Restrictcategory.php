<?php

namespace FirstVendor\PluginModule\Plugin;




class Restrictcategory
{
    protected $_url;
    protected $_responseFactory;
    public function __construct(
        \Magento\Framework\UrlInterface $url,
        \Magento\Framework\App\ResponseFactory $responseFactory
    ) {
        $this->_url = $url;
        $this->_responseFactory = $responseFactory;
    }

    public function afterGetIsActive(\Magento\Catalog\Model\Category $category)
    {


        if ($category->getData('store_id') == 1) //here you change condition as per need
        {
            // you can set any redirect url as per your requirement

            $customRedirectionUrl = $this->_url->getUrl('customer/account/login');

            $this->_responseFactory->create()->setRedirect($customRedirectionUrl)->sendResponse();
            exit;
        }
    }
}
