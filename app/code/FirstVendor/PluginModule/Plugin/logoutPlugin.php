<?php

namespace FirstVendor\PluginModule\Plugin;

class logoutPlugin
{

    private $_url;
    private $_responseFactory;
    private $customerSession;
    private $messageManager;

    public function __construct(
        \Magento\Framework\UrlInterface $url,
        \Magento\Framework\App\ResponseFactory $responseFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Message\ManagerInterface $messageManager,

    ) {

        $this->_url = $url;
        $this->_responseFactory = $responseFactory;
        $this->customerSession = $customerSession;
        $this->messageManager = $messageManager;
    }

    public function beforeExecute(
        \Magento\Cms\Controller\Page\View $subject
    ) {
        if ($this->customerSession->isLoggedIn()) {
            $cmsPageIdentifier = $subject->getRequest()->getParam('page_id');
            // echo $cmsPageIdentifier;
            // exit;


            $targetFooterLink = 5;

            if ($cmsPageIdentifier == $targetFooterLink) {

                $this->customerSession->logout();

                $this->messageManager->addSuccessMessage(__('You have been logged out.'));
                $customRedirectionUrl = $this->_url->getUrl('/index');

                $this->_responseFactory->create()->setRedirect($customRedirectionUrl)->sendResponse();
                exit;
            }
        }

        // Continue with the normal execution

    }
}
