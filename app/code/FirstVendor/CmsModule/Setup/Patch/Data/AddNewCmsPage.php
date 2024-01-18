<?php

namespace FirstVendor\CmsModule\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Cms\Model\PageFactory;


class AddNewCmsPage implements DataPatchInterface, PatchVersionInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var PageFactory
     */
    private $pageFactory;

    /**
     * AddNewCmsPage constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param PageFactory $pageFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        PageFactory $pageFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->pageFactory = $pageFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $pageData = [
            'title' => 'CMS Page',
            'page_layout' => '1column',
            'meta_keywords' => 'Page keywords',
            'meta_description' => 'Page description',
            'identifier' => 'custom-page',
            'content_heading' => 'Custom Page',
            'content' => '<div class="main-cms-content">Hello this is my first cms page.</div>',
            'layout_update_xml' => '',
            'url_key' => 'custom-page',
            'is_active' => 1,
            'stores' => [0], // store_id comma separated
            'sort_order' => 0
        ];

        $this->moduleDataSetup->startSetup();
        /* Save CMS Page logic */
        $this->pageFactory->create()->setData($pageData)->save();
        $this->moduleDataSetup->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public static function getVersion()
    {
        return '2.0.0';
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
