<?php

namespace FirstVendor\PluginModule\Plugin;

use Magento\Customer\Model\AccountManagement as Subject;
use Psr\Log\LoggerInterface;

class LoginLog
{
    private $logger;
    private $messageManager;

    public function __construct(
        LoggerInterface $logger,
        \Magento\Framework\Message\ManagerInterface $messageManager,
    ) {
        $this->messageManager = $messageManager;
        $this->logger = $logger;
    }

    public function aroundAuthenticate(Subject $subject, callable $proceed, $username, $password)
    {
        $result = $proceed($username, $password);
        $logInfo = [
            'Username' => $username,
            'Password' => '****', // You may want to obfuscate or omit the password for security reasons
            'Result' => $result ? 'Success' : 'Failure',
        ];

        // Log login attempts
        $this->logger->info('Login attempt: ' . json_encode($logInfo));
        $this->messageManager->addSuccessMessage(__('Login attempt: ' . json_encode($logInfo)));


        return $result;
    }
}
