<?php
/**
 * @author      Olegnax
 * @package     Olegnax_Athlete2
 * @copyright   Copyright (c) 2023 Olegnax (http://olegnax.com/). All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Olegnax\Athlete2\Model\Config\Settings\Icons;

use Magento\Framework\Option\ArrayInterface;
use Magento\Framework\View\Asset\Repository;

class AllCats implements ArrayInterface
{
    const TYPE_NONE = '';
    const TYPE_DEFAULT = 'default';
    const TYPE_1 = 'menu';
    const TYPE_2 = 'menu2';
    const TYPE_2_1 = 'menu3';
    const TYPE_3 = 'shop2';
    const TYPE_4 = 'grid';
    const TYPE_5 = 'store';
    const TYPE_6 = 'shop';
    const TYPE_7 = 'shop2';
    const TYPE_CUSTOM = 'custom';
    /**
     * @var array
     */
    private $styleArray;

    protected $_assetRepo;

    public function __construct(
        Repository $assetRepo
    ) {
        $this->_assetRepo = $assetRepo;
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        $array = [];
        foreach ($this->toOptionArray() as $item) {
            $array[$item['value']] = $item['label'];
        }
        return $array;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => static::TYPE_NONE,
                'label' =>$this->_assetRepo->getUrl( 'Olegnax_Athlete2::images/icons/none.png' ),
            ],
            [
                'value' => static::TYPE_DEFAULT,
                'label' => $this->_assetRepo->getUrl( 'Olegnax_Athlete2::images/icons/menu-default.png' ),
            ],
            [
                'value' => static::TYPE_1,
                'label' => $this->_assetRepo->getUrl( 'Olegnax_Athlete2::images/icons/menu-01.png' ),
            ],
            [
                'value' => static::TYPE_2,
                'label' => $this->_assetRepo->getUrl( 'Olegnax_Athlete2::images/icons/menu-02.png' ),
            ],
            [
                'value' => static::TYPE_2_1,
                'label' => $this->_assetRepo->getUrl( 'Olegnax_Athlete2::images/icons/menu-03.png' ),
            ],
            [
                'value' => static::TYPE_3,
                'label' => $this->_assetRepo->getUrl( 'Olegnax_Athlete2::images/icons/shop-02.png' ),
            ],
            [
                'value' => static::TYPE_4,
                'label' => $this->_assetRepo->getUrl( 'Olegnax_Athlete2::images/icons/grid-01.png' ),
            ],
            [
                'value' => static::TYPE_5,
                'label' => $this->_assetRepo->getUrl( 'Olegnax_Athlete2::images/icons/house-01.png' ),
            ],
            [
                'value' => static::TYPE_6,
                'label' => $this->_assetRepo->getUrl( 'Olegnax_Athlete2::images/icons/store-01.png' ),
            ],
            [
                'value' => static::TYPE_7,
                'label' => $this->_assetRepo->getUrl( 'Olegnax_Athlete2::images/icons/shop-01.png' ),
            ],
            [
                'value' => static::TYPE_CUSTOM,
                'label' =>$this->_assetRepo->getUrl( 'Olegnax_Athlete2::images/icons/custom.png' ),
            ],
        ];
    }
}
