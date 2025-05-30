<?php
/**
 * Olegnax Athlete Slideshow
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
 * @package     Olegnax_AthleteSlideshow
 * @copyright   Copyright (c) 2023 Olegnax (http://www.olegnax.com/)
 * @license     https://www.olegnax.com/license
 */


namespace Olegnax\Athlete2Slideshow\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Slider implements ArrayInterface
{

    public function toOptionArray()
    {
        return [['value' => 'athlete', 'label' => __('Athlete slider')],['value' => 'revolution', 'label' => __('Revolution Slides')]];
    }

    public function toArray()
    {
        return ['athlete' => __('Athlete slider'),'revolution' => __('Revolution Slides')];
    }
}
