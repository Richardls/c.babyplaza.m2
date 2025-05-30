<?php

/**
 * Olegnax BannerSlider
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
 * @package     Olegnax_BannerSlider
 * @copyright   Copyright (c) 2023 Olegnax (http://www.olegnax.com/)
 * @license     https://www.olegnax.com/license
 */

namespace Olegnax\BannerSlider\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class GroupActions extends Column {

	const URL_PATH_DELETE = 'bannerslider/group/delete';

	protected $urlBuilder;

	const URL_PATH_EDIT = 'bannerslider/group/edit';

	/**
	 * @param ContextInterface $context
	 * @param UiComponentFactory $uiComponentFactory
	 * @param UrlInterface $urlBuilder
	 * @param array $components
	 * @param array $data
	 */
	public function __construct(
	ContextInterface $context, UiComponentFactory $uiComponentFactory, UrlInterface $urlBuilder, array $components = [], array $data = []
	) {
		$this->urlBuilder = $urlBuilder;
		parent::__construct($context, $uiComponentFactory, $components, $data);
	}

	/**
	 * Prepare Data Source
	 *
	 * @param array $dataSource
	 * @return array
	 */
	public function prepareDataSource(array $dataSource) {
		if (isset($dataSource['data']['items'])) {
			foreach ($dataSource['data']['items'] as & $item) {
				if (isset($item['group_id'])) {
					$item[$this->getData('name')] = [
						'edit' => [
							'href' => $this->urlBuilder->getUrl(
									static::URL_PATH_EDIT, [
								'id' => $item['group_id']
									]
							),
							'label' => __('Edit')
						],
						'delete' => [
							'href' => $this->urlBuilder->getUrl(
									static::URL_PATH_DELETE, [
								'id' => $item['group_id']
									]
							),
							'label' => __('Delete'),
							'confirm' => [
								'title' => __('Delete "%1"', $item['group_name']),
								'message' => __('Are you sure you wan\'t to delete a "%1" record?', $item['group_name'])
							]
						]
					];
				}
			}
		}

		return $dataSource;
	}

}
