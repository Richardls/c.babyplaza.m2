<?php
namespace Magento\ConfigurableProduct\Helper\Data;

/**
 * Interceptor class for @see \Magento\ConfigurableProduct\Helper\Data
 */
class Interceptor extends \Magento\ConfigurableProduct\Helper\Data implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Helper\Image $imageHelper, ?\Magento\Catalog\Model\Product\Image\UrlBuilder $urlBuilder = null, ?\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig = null)
    {
        $this->___init();
        parent::__construct($imageHelper, $urlBuilder, $scopeConfig);
    }

    /**
     * {@inheritdoc}
     */
    public function getGalleryImages(\Magento\Catalog\Api\Data\ProductInterface $product)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getGalleryImages');
        return $pluginInfo ? $this->___callPlugins('getGalleryImages', func_get_args(), $pluginInfo) : parent::getGalleryImages($product);
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions($currentProduct, $allowedProducts)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getOptions');
        return $pluginInfo ? $this->___callPlugins('getOptions', func_get_args(), $pluginInfo) : parent::getOptions($currentProduct, $allowedProducts);
    }

    /**
     * {@inheritdoc}
     */
    public function getAllowAttributes($product)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getAllowAttributes');
        return $pluginInfo ? $this->___callPlugins('getAllowAttributes', func_get_args(), $pluginInfo) : parent::getAllowAttributes($product);
    }
}
