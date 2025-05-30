<?php
/**
 * @author      Olegnax
 * @package     Olegnax_HotSpotQuickview
 * @copyright   Copyright (c) 2023 Olegnax (http://olegnax.com/). All rights reserved.
 * See COPYING.txt for license details.
 * @noinspection PhpDeprecationInspection
 */
declare(strict_types=1);

namespace Olegnax\HotSpotQuickview\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Icon implements ArrayInterface
{
    const ICON_NONE = '';
	const ICON_PLUS = 'plus';
	const ICON_PLUS_SMALL = 'plus-small';
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
			['value' => static::ICON_NONE, 'label' => __('None')],
			['value' => static::ICON_PLUS, 'label' => __('Plus')],
			['value' => static::ICON_PLUS_SMALL, 'label' => __('Plus small')],
        ];
    }
}
