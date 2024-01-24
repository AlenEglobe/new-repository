<?php

namespace FirstVendor\PluginModule\Plugin;

class AppendName
{

    public function afterGetName(\Magento\Catalog\Model\Product $subject, $result)
    {
        return "alen.magento.com" . $result; // Adding XYZ name to before the product name
    }
}
