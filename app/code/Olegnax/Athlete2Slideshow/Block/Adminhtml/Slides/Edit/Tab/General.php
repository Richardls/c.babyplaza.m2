<?php

namespace Olegnax\Athlete2Slideshow\Block\Adminhtml\Slides\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;
use Magento\Store\Model\System\Store;

class General extends Generic implements TabInterface {

	/**
	 * @var Store
	 */
	protected $_systemStore;

	public function __construct(
		Store $systemStore,
		Context $context,
		Registry $registry,
		FormFactory $formFactory,
		array $data = []
	) {
		$this->_systemStore = $systemStore;
		parent::__construct($context, $registry, $formFactory, $data);
	}

	protected function _prepareForm() {
		$model = $this->_coreRegistry->registry('olegnax_athlete2slideshow_slide');
		$form = $this->_formFactory->create();
		$fieldset = $form->addFieldset(
				'base_fieldset', ['legend' => __('General')]
		);

		if ($model->getId()) {
			$fieldset->addField(
					'id', 'hidden', ['name' => 'id']
			);
		}

		if (!$this->_storeManager->isSingleStoreMode()) {
			$rendererBlock = $this->getLayout()->createBlock('Magento\Backend\Block\Store\Switcher\Form\Renderer\Fieldset\Element');
			$fieldset->addField('store_id', 'multiselect', [
				'name' => 'store_id',
				'label' => __('Store Views'),
				'title' => __('Store Views'),
				'required' => true,
				'values' => $this->_systemStore->getStoreValuesForForm(false, true)
			])->setRenderer($rendererBlock);
		} else {
			$fieldset->addField('store_id', 'hidden', [
				'name' => 'store_id',
				'value' => $this->_storeManager->getStore()->getId()
			]);
		}
		$fieldset->addField('image', 'image', array(
			'label' => __('Background Image'),
			'required' => true,
			'name' => 'image',
		));
		$fieldset->addField('title_color', 'text', array(
			'label' => __('Title color'),
			'name' => 'title_color',
			'note' => 'Leave empty to use default colors',
			'class' => 'ox-ss-colorpicker',
		));
		$fieldset->addField('title_bg', 'text', array(
			'label' => __('Title background'),
			'name' => 'title_bg',
			'note' => 'Leave empty to use default colors',
			'class' => 'ox-ss-colorpicker',
		));
		$fieldset->addField('title', 'textarea', [
			'name' => 'title',
			'label' => __('Title'),
			'required' => false
		]);
		$fieldset->addField('link_color', 'text', array(
			'label' => __('Link color'),
			'name' => 'link_color',
			'note' => 'Leave empty to use default colors',
			'class' => 'ox-ss-colorpicker',
		));
		$fieldset->addField('link_bg', 'text', array(
			'label' => __('Link background'),
			'name' => 'link_bg',
			'note' => 'Leave empty to use default colors',
			'class' => 'ox-ss-colorpicker',
		));
		$fieldset->addField('link_hover_color', 'text', array(
			'label' => __('Link hover color'),
			'name' => 'link_hover_color',
			'note' => 'Leave empty to use default colors',
			'class' => 'ox-ss-colorpicker',
		));
		$fieldset->addField('link_hover_bg', 'text', array(
			'label' => __('Link hover background'),
			'name' => 'link_hover_bg',
			'note' => 'Leave empty to use default colors',
			'class' => 'ox-ss-colorpicker',
		));
		$fieldset->addField('link_text', 'text', array(
			'label' => __('Link text'),
			'required' => false,
			'name' => 'link_text',
		));
		$fieldset->addField('link_href', 'text', array(
			'label' => __('Link Url'),
			'required' => false,
			'name' => 'link_href',
		));

		$fieldset->addField('banner_1_img', 'image', array(
			'label' => __('Banner 1 image'),
			'required' => false,
			'name' => 'banner_1_img',
		));
		$fieldset->addField('banner_1_imgX2', 'image', array(
			'label' => __('Banner 1 image for Retina'),
			'required' => false,
			'name' => 'banner_1_imgX2',
			'note' => 'Upload double size image for retina<br/>',
		));
		$fieldset->addField('banner_1_href', 'text', array(
			'label' => __('Banner 1 Url'),
			'required' => false,
			'name' => 'banner_1_href',
		));

		$fieldset->addField('banner_2_img', 'image', array(
			'label' => __('Banner 2 image'),
			'required' => false,
			'name' => 'banner_2_img',
		));
		$fieldset->addField('banner_2_imgX2', 'image', array(
			'label' => __('Banner 2 image for Retina'),
			'required' => false,
			'name' => 'banner_2_imgX2',
			'note' => 'Upload double size image for retina<br/>',
		));
		$fieldset->addField('banner_2_href', 'text', array(
			'label' => __('Banner 2 Url'),
			'required' => false,
			'name' => 'banner_2_href',
		));
		$fieldset->addField('status', 'select', [
			'name' => 'status',
			'label' => __('Status'),
			'title' => __('Status'),
			'required' => true,
			'options' => [
				'1' => __('Enable'),
				'0' => __('Disable')
			]
		]);
		$fieldset->addField('sort_order', 'text', array(
			'label' => __('Sort Order'),
			'required' => false,
			'name' => 'sort_order',
		));

		if (!$model->getId()) {
			$model->setData('store_id', '0');
			$model->setData('status', '1');
			$model->setData('sort_order', '10');
		}



		$data = $model->getData();
		$form->setValues($data);
		$this->setForm($form);

		return parent::_prepareForm();
	}

	public function getTabLabel() {
		return __('General');
	}

	public function getTabTitle() {
		return __('General');
	}

	public function canShowTab() {
		return true;
	}

	public function isHidden() {
		return false;
	}

}
