<?php

namespace Olegnax\ProductLabel\Model\Config;

use Magento\Framework\Option\ArrayInterface;

class Period implements ArrayInterface {

	public function toOptionArray()
    {
        return [
			[
				'value' => '',
				'label' => __('All Time')
			],
			[
				'value' => 'year',
				'label' => __('Last Year')
			],
			[
				'value' => 'month',
				'label' => __('Last Month')
			]
        ];
    }
    public function toArray()
    {
        $array = [];
        foreach ($this->toOptionArray() as $item) {
            $array[$item['value']] = $item['label'];
        }
        return $array;
    }

}
