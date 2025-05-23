<?php

/**
 * Olegnax BrandSlider
 *
 * This file is part of Olegnax/Core.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Olegnax.com license that is
 * available through the world-wide-web at this URL:
 * https://www.olegnax.com/license
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Olegnax
 * @package     Olegnax_BrandSlider
 * @copyright   Copyright (c) 2023 Olegnax (http://www.olegnax.com/)
 * @license     https://www.olegnax.com/license
 */

namespace Olegnax\BrandSlider\Block;

use Magento\Customer\Model\Context;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use Olegnax\BrandSlider\Helper\Helper;

class BrandSlider extends Template implements BlockInterface
{

    /**
     * @var \Magento\Framework\App\Http\Context
     */
    protected $httpContext;

    /**
     * Json Serializer Instance
     *
     * @var Json
     */
    private $json;
    /**
     * @var Helper
     */
    private $helper;

    public function __construct(
        Template\Context $context,
        \Magento\Framework\App\Http\Context $httpContext,
        Helper $helper,
        Json $json,
        array $data = []
    ) {
        $this->httpContext = $httpContext;
        $this->helper = $helper;
        $this->json = $json ?? ObjectManager::getInstance()->get(Json::class);
        parent::__construct($context, $data);
    }

    public function getCacheKeyInfo($newval = [])
    {
        return array_merge([
            'OLEGNAX_BRANDSLIDER_WIDGET',
            $this->_storeManager->getStore()->getId(),
            $this->_design->getDesignTheme()->getId(),
            $this->httpContext->getValue(Context::CONTEXT_GROUP),
            $this->json->serialize($this->getRequest()->getParams()),
            $this->json->serialize($this->getData()),
        ], parent::getCacheKeyInfo(), $newval);
    }

    public function getSliderId()
    {
        return 'ox_' . $this->getNameInLayout();
    }

    public function prepareStyle(array $style, string $separatorValue = ': ', string $separatorAttribute = ';')
    {
        $style = array_filter($style);
        if (empty($style)) {
            return '';
        }
        foreach ($style as $key => &$value) {
            $value = $key . $separatorValue . $value;
        }
        $style = implode($separatorAttribute, $style);

        return $style;
    }
    public function getResponsive($to_string = true)
    {
        $width = $this->getWidth();
        $responsive = [
            0 => [
                'items' => 1,
            ],
        ];
        $j = 1;
        for ($i = $width + 1; $i < 3000; $i += $width) {
            $j++;
            $responsive[$i] = [
                'items' => $j,
            ];
        }

        if ($to_string) {
            return json_encode($responsive);
        }

        return $responsive;
    }

    public function getAutoScroll()
    {
        $auto_scroll = $this->getData('auto_scroll');
        if (empty($auto_scroll)) {
            $auto_scroll = 0;
        }

        return $auto_scroll;
    }

    public function getItems()
    {
        $_attr = $this->getData('items_attr') ?: '';
        return $this->helper->getItems($this->getData('items_list'), $_attr);
    }

    public function getBrandUrl($item)
    {
        return $this->getUrl('catalogsearch/result/') . '?q=' . $item->getLabel();
    }

    protected function _construct()
    {
        $this->addData([
            'cache_lifetime' => 86400,
        ]);
        if (!$this->hasData('template') && !$this->getTemplate()) {
            $this->setTemplate('Olegnax_BrandSlider::brandslider.phtml');
        }
        parent::_construct();
    }
}
