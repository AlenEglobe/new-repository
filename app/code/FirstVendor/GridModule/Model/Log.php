<?php

namespace FirstVendor\GridModue\Model;

use Magento\Framework\Model\AbstractModel;

class Log extends AbstractModel
{

    const CACHE_TAG = 'id';

    protected function _construct()

    {

        $this->_init('FirstVendor\GridModule\Model\ResourceModel\Log');
    }
}
