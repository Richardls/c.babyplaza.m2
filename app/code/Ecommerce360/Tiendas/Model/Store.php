<?php
namespace Ecommerce360\Tiendas\Model;

use Magento\Framework\Model\AbstractModel;
use Ecommerce360\Tiendas\Model\ResourceModel\Store as StoreResourceModel;

class Store extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(StoreResourceModel::class);
    }

    /**
     * Convert `payment_methods` and `delivery_options` arrays to JSON before saving
     */
    public function beforeSave()
    {
        // Convertir payment_methods a JSON si es un array
        $paymentMethods = $this->getData('payment_methods');
        if (is_array($paymentMethods)) {
            $this->setData('payment_methods', json_encode($paymentMethods));
        }

        // Convertir delivery_options a JSON si es un array
        $deliveryOptions = $this->getData('delivery_options');
        if (is_array($deliveryOptions)) {
            $this->setData('delivery_options', json_encode($deliveryOptions));
        }

        return parent::beforeSave();
    }

    /**
     * Convert `payment_methods` and `delivery_options` JSON strings to arrays after loading
     */
    public function afterLoad()
    {
        // Convertir JSON de payment_methods de vuelta a array
        $paymentMethods = $this->getData('payment_methods');
        if (is_string($paymentMethods)) {
            $this->setData('payment_methods', json_decode($paymentMethods, true));
        }

        // Convertir JSON de delivery_options de vuelta a array
        $deliveryOptions = $this->getData('delivery_options');
        if (is_string($deliveryOptions)) {
            $this->setData('delivery_options', json_decode($deliveryOptions, true));
        }

        return parent::afterLoad();
    }
}
