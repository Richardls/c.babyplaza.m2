<?php

namespace Olegnax\Athlete2\Model\Config\Settings;

use Magento\Framework\Option\ArrayInterface;

class FontDisplay implements ArrayInterface {

	public function toOptionArray() {
		$optionArray = [ ];
		$array		 = $this->toArray();
		foreach ( $array as $key => $value ) {
			$optionArray[] = [ 'value' => $key, 'label' => $value ];
		}

		return $optionArray;
	}

	public function toArray() {
		return [
			'fallback'		 => __( 'Fallback' ),
			'auto'		 => __( 'Auto' ),
			'block'	 => __( 'Block' ),
			'swap'	 => __( 'Swap' ),
			'optional'	 => __( 'Optional' ),
		];
	}

}
