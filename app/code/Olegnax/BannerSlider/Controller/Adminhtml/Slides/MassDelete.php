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

namespace Olegnax\BannerSlider\Controller\Adminhtml\Slides;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Olegnax\BannerSlider\Model\ResourceModel\Slides\CollectionFactory;

class MassDelete extends Action {
    const ADMIN_RESOURCE = 'Olegnax_BannerSlider::Slide_Delete';
	protected $_filter;
	protected $_collectionFactory;

	public function __construct(
	Context $context, Filter $filter,
 CollectionFactory $collectionFactory
	) {
		$this->_filter				 = $filter;
		$this->_collectionFactory	 = $collectionFactory;

		parent::__construct( $context );
	}

	public function execute() {
		$collection	 = $this->_filter->getCollection( $this->_collectionFactory->create() );
		$delete		 = 0;
		if ( !empty( $collection ) ) {
			foreach ( $collection as $item ) {
				$item->delete();
				$delete++;
			}
			$this->messageManager->addSuccessMessage( __( 'A total of %1 record(s) have been deleted.', $delete ) );
		} else {
			$this->messageManager->addException( __( 'Nothing selected!' ) );
		}


		$resultRedirect = $this->resultFactory->create( ResultFactory::TYPE_REDIRECT );

		return $resultRedirect->setPath( '*/*/' );
	}

}
