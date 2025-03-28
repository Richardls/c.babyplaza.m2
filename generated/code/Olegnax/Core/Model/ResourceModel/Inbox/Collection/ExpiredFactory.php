<?php
namespace Olegnax\Core\Model\ResourceModel\Inbox\Collection;

/**
 * Factory class for @see \Olegnax\Core\Model\ResourceModel\Inbox\Collection\Expired
 */
class ExpiredFactory
{
    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager = null;

    /**
     * Instance name to create
     *
     * @var string
     */
    protected $_instanceName = null;

    /**
     * Factory constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param string $instanceName
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\Olegnax\\Core\\Model\\ResourceModel\\Inbox\\Collection\\Expired')
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }

    /**
     * Create class instance with specified parameters
     *
     * @param array $data
     * @return \Olegnax\Core\Model\ResourceModel\Inbox\Collection\Expired
     */
    public function create(array $data = [])
    {
        return $this->_objectManager->create($this->_instanceName, $data);
    }
}
