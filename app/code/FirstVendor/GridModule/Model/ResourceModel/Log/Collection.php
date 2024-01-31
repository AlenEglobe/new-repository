<?php

namespace FirstVendor\GridModule\Model\ResourceModel\Log;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection

{

    protected function _construct()

    {

        $this->_init('FirstVendor\GridModule\Model\Log', 'FirstVendor\GridModule\Model\ResourceModel\Log');
    }
}
