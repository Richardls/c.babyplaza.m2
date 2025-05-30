<?php
namespace Magento\Reports\Model\ResourceModel\Product\Sold\Collection;

/**
 * Interceptor class for @see \Magento\Reports\Model\ResourceModel\Product\Sold\Collection
 */
class Interceptor extends \Magento\Reports\Model\ResourceModel\Product\Sold\Collection implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Data\Collection\EntityFactory $entityFactory, \Psr\Log\LoggerInterface $logger, \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy, \Magento\Framework\Event\ManagerInterface $eventManager, \Magento\Framework\Model\ResourceModel\Db\VersionControl\Snapshot $entitySnapshot, \Magento\Framework\DB\Helper $coreResourceHelper, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate, \Magento\Sales\Model\Order\Config $orderConfig, \Magento\Sales\Model\ResourceModel\Report\OrderFactory $reportOrderFactory, ?\Magento\Framework\DB\Adapter\AdapterInterface $connection = null, ?\Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null)
    {
        $this->___init();
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $entitySnapshot, $coreResourceHelper, $scopeConfig, $storeManager, $localeDate, $orderConfig, $reportOrderFactory, $connection, $resource);
    }

    /**
     * {@inheritdoc}
     */
    public function setDateRange($from, $to)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setDateRange');
        return $pluginInfo ? $this->___callPlugins('setDateRange', func_get_args(), $pluginInfo) : parent::setDateRange($from, $to);
    }

    /**
     * {@inheritdoc}
     */
    public function addOrderedQty($from = '', $to = '')
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addOrderedQty');
        return $pluginInfo ? $this->___callPlugins('addOrderedQty', func_get_args(), $pluginInfo) : parent::addOrderedQty($from, $to);
    }

    /**
     * {@inheritdoc}
     */
    public function setStoreIds($storeIds)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setStoreIds');
        return $pluginInfo ? $this->___callPlugins('setStoreIds', func_get_args(), $pluginInfo) : parent::setStoreIds($storeIds);
    }

    /**
     * {@inheritdoc}
     */
    public function setOrder($attribute, $dir = 'DESC')
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setOrder');
        return $pluginInfo ? $this->___callPlugins('setOrder', func_get_args(), $pluginInfo) : parent::setOrder($attribute, $dir);
    }

    /**
     * {@inheritdoc}
     */
    public function getSelectCountSql()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSelectCountSql');
        return $pluginInfo ? $this->___callPlugins('getSelectCountSql', func_get_args(), $pluginInfo) : parent::getSelectCountSql();
    }

    /**
     * {@inheritdoc}
     */
    public function checkIsLive($range)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'checkIsLive');
        return $pluginInfo ? $this->___callPlugins('checkIsLive', func_get_args(), $pluginInfo) : parent::checkIsLive($range);
    }

    /**
     * {@inheritdoc}
     */
    public function isLive()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isLive');
        return $pluginInfo ? $this->___callPlugins('isLive', func_get_args(), $pluginInfo) : parent::isLive();
    }

    /**
     * {@inheritdoc}
     */
    public function prepareSummary($range, $customStart, $customEnd, $isFilter = 0)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'prepareSummary');
        return $pluginInfo ? $this->___callPlugins('prepareSummary', func_get_args(), $pluginInfo) : parent::prepareSummary($range, $customStart, $customEnd, $isFilter);
    }

    /**
     * {@inheritdoc}
     */
    public function getDateRange($range, $customStart, $customEnd, $returnObjects = false)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getDateRange');
        return $pluginInfo ? $this->___callPlugins('getDateRange', func_get_args(), $pluginInfo) : parent::getDateRange($range, $customStart, $customEnd, $returnObjects);
    }

    /**
     * {@inheritdoc}
     */
    public function addItemCountExpr()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addItemCountExpr');
        return $pluginInfo ? $this->___callPlugins('addItemCountExpr', func_get_args(), $pluginInfo) : parent::addItemCountExpr();
    }

    /**
     * {@inheritdoc}
     */
    public function calculateTotals($isFilter = 0)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'calculateTotals');
        return $pluginInfo ? $this->___callPlugins('calculateTotals', func_get_args(), $pluginInfo) : parent::calculateTotals($isFilter);
    }

    /**
     * {@inheritdoc}
     */
    public function calculateSales($isFilter = 0)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'calculateSales');
        return $pluginInfo ? $this->___callPlugins('calculateSales', func_get_args(), $pluginInfo) : parent::calculateSales($isFilter);
    }

    /**
     * {@inheritdoc}
     */
    public function groupByCustomer()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'groupByCustomer');
        return $pluginInfo ? $this->___callPlugins('groupByCustomer', func_get_args(), $pluginInfo) : parent::groupByCustomer();
    }

    /**
     * {@inheritdoc}
     */
    public function joinCustomerName($alias = 'name')
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'joinCustomerName');
        return $pluginInfo ? $this->___callPlugins('joinCustomerName', func_get_args(), $pluginInfo) : parent::joinCustomerName($alias);
    }

    /**
     * {@inheritdoc}
     */
    public function addOrdersCount()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addOrdersCount');
        return $pluginInfo ? $this->___callPlugins('addOrdersCount', func_get_args(), $pluginInfo) : parent::addOrdersCount();
    }

    /**
     * {@inheritdoc}
     */
    public function addRevenueToSelect($convertCurrency = false)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addRevenueToSelect');
        return $pluginInfo ? $this->___callPlugins('addRevenueToSelect', func_get_args(), $pluginInfo) : parent::addRevenueToSelect($convertCurrency);
    }

    /**
     * {@inheritdoc}
     */
    public function addSumAvgTotals($storeId = 0)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addSumAvgTotals');
        return $pluginInfo ? $this->___callPlugins('addSumAvgTotals', func_get_args(), $pluginInfo) : parent::addSumAvgTotals($storeId);
    }

    /**
     * {@inheritdoc}
     */
    public function orderByTotalAmount($dir = 'DESC')
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'orderByTotalAmount');
        return $pluginInfo ? $this->___callPlugins('orderByTotalAmount', func_get_args(), $pluginInfo) : parent::orderByTotalAmount($dir);
    }

    /**
     * {@inheritdoc}
     */
    public function orderByOrdersCount($dir = 'DESC')
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'orderByOrdersCount');
        return $pluginInfo ? $this->___callPlugins('orderByOrdersCount', func_get_args(), $pluginInfo) : parent::orderByOrdersCount($dir);
    }

    /**
     * {@inheritdoc}
     */
    public function orderByCustomerRegistration($dir = 'DESC')
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'orderByCustomerRegistration');
        return $pluginInfo ? $this->___callPlugins('orderByCustomerRegistration', func_get_args(), $pluginInfo) : parent::orderByCustomerRegistration($dir);
    }

    /**
     * {@inheritdoc}
     */
    public function orderByCreatedAt($dir = 'DESC')
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'orderByCreatedAt');
        return $pluginInfo ? $this->___callPlugins('orderByCreatedAt', func_get_args(), $pluginInfo) : parent::orderByCreatedAt($dir);
    }

    /**
     * {@inheritdoc}
     */
    public function addCreateAtPeriodFilter($period)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addCreateAtPeriodFilter');
        return $pluginInfo ? $this->___callPlugins('addCreateAtPeriodFilter', func_get_args(), $pluginInfo) : parent::addCreateAtPeriodFilter($period);
    }

    /**
     * {@inheritdoc}
     */
    public function addAddressFields()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addAddressFields');
        return $pluginInfo ? $this->___callPlugins('addAddressFields', func_get_args(), $pluginInfo) : parent::addAddressFields();
    }

    /**
     * {@inheritdoc}
     */
    public function addFieldToSearchFilter($field, $condition = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addFieldToSearchFilter');
        return $pluginInfo ? $this->___callPlugins('addFieldToSearchFilter', func_get_args(), $pluginInfo) : parent::addFieldToSearchFilter($field, $condition);
    }

    /**
     * {@inheritdoc}
     */
    public function addAttributeToSearchFilter($attributes, $condition = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addAttributeToSearchFilter');
        return $pluginInfo ? $this->___callPlugins('addAttributeToSearchFilter', func_get_args(), $pluginInfo) : parent::addAttributeToSearchFilter($attributes, $condition);
    }

    /**
     * {@inheritdoc}
     */
    public function addBillingAgreementsFilter($agreements)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addBillingAgreementsFilter');
        return $pluginInfo ? $this->___callPlugins('addBillingAgreementsFilter', func_get_args(), $pluginInfo) : parent::addBillingAgreementsFilter($agreements);
    }

    /**
     * {@inheritdoc}
     */
    public function setSelectCountSql(\Magento\Framework\DB\Select $countSelect)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setSelectCountSql');
        return $pluginInfo ? $this->___callPlugins('setSelectCountSql', func_get_args(), $pluginInfo) : parent::setSelectCountSql($countSelect);
    }

    /**
     * {@inheritdoc}
     */
    public function addAttributeToSelect($attribute)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addAttributeToSelect');
        return $pluginInfo ? $this->___callPlugins('addAttributeToSelect', func_get_args(), $pluginInfo) : parent::addAttributeToSelect($attribute);
    }

    /**
     * {@inheritdoc}
     */
    public function addAttributeToFilter($attribute, $condition = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addAttributeToFilter');
        return $pluginInfo ? $this->___callPlugins('addAttributeToFilter', func_get_args(), $pluginInfo) : parent::addAttributeToFilter($attribute, $condition);
    }

    /**
     * {@inheritdoc}
     */
    public function addAttributeToSort($attribute, $dir = 'asc')
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addAttributeToSort');
        return $pluginInfo ? $this->___callPlugins('addAttributeToSort', func_get_args(), $pluginInfo) : parent::addAttributeToSort($attribute, $dir);
    }

    /**
     * {@inheritdoc}
     */
    public function setPage($pageNum, $pageSize)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setPage');
        return $pluginInfo ? $this->___callPlugins('setPage', func_get_args(), $pluginInfo) : parent::setPage($pageNum, $pageSize);
    }

    /**
     * {@inheritdoc}
     */
    public function getAllIds($limit = null, $offset = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getAllIds');
        return $pluginInfo ? $this->___callPlugins('getAllIds', func_get_args(), $pluginInfo) : parent::getAllIds($limit, $offset);
    }

    /**
     * {@inheritdoc}
     */
    public function getSearchCriteria()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSearchCriteria');
        return $pluginInfo ? $this->___callPlugins('getSearchCriteria', func_get_args(), $pluginInfo) : parent::getSearchCriteria();
    }

    /**
     * {@inheritdoc}
     */
    public function setSearchCriteria(?\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setSearchCriteria');
        return $pluginInfo ? $this->___callPlugins('setSearchCriteria', func_get_args(), $pluginInfo) : parent::setSearchCriteria($searchCriteria);
    }

    /**
     * {@inheritdoc}
     */
    public function getTotalCount()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getTotalCount');
        return $pluginInfo ? $this->___callPlugins('getTotalCount', func_get_args(), $pluginInfo) : parent::getTotalCount();
    }

    /**
     * {@inheritdoc}
     */
    public function setTotalCount($totalCount)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setTotalCount');
        return $pluginInfo ? $this->___callPlugins('setTotalCount', func_get_args(), $pluginInfo) : parent::setTotalCount($totalCount);
    }

    /**
     * {@inheritdoc}
     */
    public function setItems(?array $items = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setItems');
        return $pluginInfo ? $this->___callPlugins('setItems', func_get_args(), $pluginInfo) : parent::setItems($items);
    }

    /**
     * {@inheritdoc}
     */
    public function fetchItem()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'fetchItem');
        return $pluginInfo ? $this->___callPlugins('fetchItem', func_get_args(), $pluginInfo) : parent::fetchItem();
    }

    /**
     * {@inheritdoc}
     */
    public function getMainTable()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getMainTable');
        return $pluginInfo ? $this->___callPlugins('getMainTable', func_get_args(), $pluginInfo) : parent::getMainTable();
    }

    /**
     * {@inheritdoc}
     */
    public function setMainTable($table)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setMainTable');
        return $pluginInfo ? $this->___callPlugins('setMainTable', func_get_args(), $pluginInfo) : parent::setMainTable($table);
    }

    /**
     * {@inheritdoc}
     */
    public function getSelect()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSelect');
        return $pluginInfo ? $this->___callPlugins('getSelect', func_get_args(), $pluginInfo) : parent::getSelect();
    }

    /**
     * {@inheritdoc}
     */
    public function addFieldToSelect($field, $alias = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addFieldToSelect');
        return $pluginInfo ? $this->___callPlugins('addFieldToSelect', func_get_args(), $pluginInfo) : parent::addFieldToSelect($field, $alias);
    }

    /**
     * {@inheritdoc}
     */
    public function addExpressionFieldToSelect($alias, $expression, $fields)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addExpressionFieldToSelect');
        return $pluginInfo ? $this->___callPlugins('addExpressionFieldToSelect', func_get_args(), $pluginInfo) : parent::addExpressionFieldToSelect($alias, $expression, $fields);
    }

    /**
     * {@inheritdoc}
     */
    public function removeFieldFromSelect($field, $isAlias = false)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'removeFieldFromSelect');
        return $pluginInfo ? $this->___callPlugins('removeFieldFromSelect', func_get_args(), $pluginInfo) : parent::removeFieldFromSelect($field, $isAlias);
    }

    /**
     * {@inheritdoc}
     */
    public function removeAllFieldsFromSelect()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'removeAllFieldsFromSelect');
        return $pluginInfo ? $this->___callPlugins('removeAllFieldsFromSelect', func_get_args(), $pluginInfo) : parent::removeAllFieldsFromSelect();
    }

    /**
     * {@inheritdoc}
     */
    public function setModel($model)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setModel');
        return $pluginInfo ? $this->___callPlugins('setModel', func_get_args(), $pluginInfo) : parent::setModel($model);
    }

    /**
     * {@inheritdoc}
     */
    public function getModelName()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getModelName');
        return $pluginInfo ? $this->___callPlugins('getModelName', func_get_args(), $pluginInfo) : parent::getModelName();
    }

    /**
     * {@inheritdoc}
     */
    public function setResourceModel($model)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setResourceModel');
        return $pluginInfo ? $this->___callPlugins('setResourceModel', func_get_args(), $pluginInfo) : parent::setResourceModel($model);
    }

    /**
     * {@inheritdoc}
     */
    public function getResourceModelName()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getResourceModelName');
        return $pluginInfo ? $this->___callPlugins('getResourceModelName', func_get_args(), $pluginInfo) : parent::getResourceModelName();
    }

    /**
     * {@inheritdoc}
     */
    public function getResource()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getResource');
        return $pluginInfo ? $this->___callPlugins('getResource', func_get_args(), $pluginInfo) : parent::getResource();
    }

    /**
     * {@inheritdoc}
     */
    public function getTable($table)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getTable');
        return $pluginInfo ? $this->___callPlugins('getTable', func_get_args(), $pluginInfo) : parent::getTable($table);
    }

    /**
     * {@inheritdoc}
     */
    public function join($table, $cond, $cols = '*')
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'join');
        return $pluginInfo ? $this->___callPlugins('join', func_get_args(), $pluginInfo) : parent::join($table, $cond, $cols);
    }

    /**
     * {@inheritdoc}
     */
    public function setResetItemsDataChanged($flag)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setResetItemsDataChanged');
        return $pluginInfo ? $this->___callPlugins('setResetItemsDataChanged', func_get_args(), $pluginInfo) : parent::setResetItemsDataChanged($flag);
    }

    /**
     * {@inheritdoc}
     */
    public function resetItemsDataChanged()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'resetItemsDataChanged');
        return $pluginInfo ? $this->___callPlugins('resetItemsDataChanged', func_get_args(), $pluginInfo) : parent::resetItemsDataChanged();
    }

    /**
     * {@inheritdoc}
     */
    public function save()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'save');
        return $pluginInfo ? $this->___callPlugins('save', func_get_args(), $pluginInfo) : parent::save();
    }

    /**
     * {@inheritdoc}
     */
    public function addBindParam($name, $value)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addBindParam');
        return $pluginInfo ? $this->___callPlugins('addBindParam', func_get_args(), $pluginInfo) : parent::addBindParam($name, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getIdFieldName()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getIdFieldName');
        return $pluginInfo ? $this->___callPlugins('getIdFieldName', func_get_args(), $pluginInfo) : parent::getIdFieldName();
    }

    /**
     * {@inheritdoc}
     */
    public function setConnection(\Magento\Framework\DB\Adapter\AdapterInterface $conn)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setConnection');
        return $pluginInfo ? $this->___callPlugins('setConnection', func_get_args(), $pluginInfo) : parent::setConnection($conn);
    }

    /**
     * {@inheritdoc}
     */
    public function getConnection()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getConnection');
        return $pluginInfo ? $this->___callPlugins('getConnection', func_get_args(), $pluginInfo) : parent::getConnection();
    }

    /**
     * {@inheritdoc}
     */
    public function getSize()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSize');
        return $pluginInfo ? $this->___callPlugins('getSize', func_get_args(), $pluginInfo) : parent::getSize();
    }

    /**
     * {@inheritdoc}
     */
    public function getSelectSql($stringMode = false)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSelectSql');
        return $pluginInfo ? $this->___callPlugins('getSelectSql', func_get_args(), $pluginInfo) : parent::getSelectSql($stringMode);
    }

    /**
     * {@inheritdoc}
     */
    public function addOrder($field, $direction = 'DESC')
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addOrder');
        return $pluginInfo ? $this->___callPlugins('addOrder', func_get_args(), $pluginInfo) : parent::addOrder($field, $direction);
    }

    /**
     * {@inheritdoc}
     */
    public function unshiftOrder($field, $direction = 'DESC')
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'unshiftOrder');
        return $pluginInfo ? $this->___callPlugins('unshiftOrder', func_get_args(), $pluginInfo) : parent::unshiftOrder($field, $direction);
    }

    /**
     * {@inheritdoc}
     */
    public function addFieldToFilter($field, $condition = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addFieldToFilter');
        return $pluginInfo ? $this->___callPlugins('addFieldToFilter', func_get_args(), $pluginInfo) : parent::addFieldToFilter($field, $condition);
    }

    /**
     * {@inheritdoc}
     */
    public function distinct($flag)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'distinct');
        return $pluginInfo ? $this->___callPlugins('distinct', func_get_args(), $pluginInfo) : parent::distinct($flag);
    }

    /**
     * {@inheritdoc}
     */
    public function load($printQuery = false, $logQuery = false)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'load');
        return $pluginInfo ? $this->___callPlugins('load', func_get_args(), $pluginInfo) : parent::load($printQuery, $logQuery);
    }

    /**
     * {@inheritdoc}
     */
    public function loadWithFilter($printQuery = false, $logQuery = false)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'loadWithFilter');
        return $pluginInfo ? $this->___callPlugins('loadWithFilter', func_get_args(), $pluginInfo) : parent::loadWithFilter($printQuery, $logQuery);
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getData');
        return $pluginInfo ? $this->___callPlugins('getData', func_get_args(), $pluginInfo) : parent::getData();
    }

    /**
     * {@inheritdoc}
     */
    public function resetData()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'resetData');
        return $pluginInfo ? $this->___callPlugins('resetData', func_get_args(), $pluginInfo) : parent::resetData();
    }

    /**
     * {@inheritdoc}
     */
    public function loadData($printQuery = false, $logQuery = false)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'loadData');
        return $pluginInfo ? $this->___callPlugins('loadData', func_get_args(), $pluginInfo) : parent::loadData($printQuery, $logQuery);
    }

    /**
     * {@inheritdoc}
     */
    public function printLogQuery($printQuery = false, $logQuery = false, $sql = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'printLogQuery');
        return $pluginInfo ? $this->___callPlugins('printLogQuery', func_get_args(), $pluginInfo) : parent::printLogQuery($printQuery, $logQuery, $sql);
    }

    /**
     * {@inheritdoc}
     */
    public function addFilterToMap($filter, $alias, $group = 'fields')
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addFilterToMap');
        return $pluginInfo ? $this->___callPlugins('addFilterToMap', func_get_args(), $pluginInfo) : parent::addFilterToMap($filter, $alias, $group);
    }

    /**
     * {@inheritdoc}
     */
    public function joinExtensionAttribute(\Magento\Framework\Api\ExtensionAttribute\JoinDataInterface $join, \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $extensionAttributesJoinProcessor)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'joinExtensionAttribute');
        return $pluginInfo ? $this->___callPlugins('joinExtensionAttribute', func_get_args(), $pluginInfo) : parent::joinExtensionAttribute($join, $extensionAttributesJoinProcessor);
    }

    /**
     * {@inheritdoc}
     */
    public function getItemObjectClass()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getItemObjectClass');
        return $pluginInfo ? $this->___callPlugins('getItemObjectClass', func_get_args(), $pluginInfo) : parent::getItemObjectClass();
    }

    /**
     * {@inheritdoc}
     */
    public function addFilter($field, $value, $type = 'and')
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addFilter');
        return $pluginInfo ? $this->___callPlugins('addFilter', func_get_args(), $pluginInfo) : parent::addFilter($field, $value, $type);
    }

    /**
     * {@inheritdoc}
     */
    public function getFilter($field)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getFilter');
        return $pluginInfo ? $this->___callPlugins('getFilter', func_get_args(), $pluginInfo) : parent::getFilter($field);
    }

    /**
     * {@inheritdoc}
     */
    public function isLoaded()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isLoaded');
        return $pluginInfo ? $this->___callPlugins('isLoaded', func_get_args(), $pluginInfo) : parent::isLoaded();
    }

    /**
     * {@inheritdoc}
     */
    public function getCurPage($displacement = 0)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getCurPage');
        return $pluginInfo ? $this->___callPlugins('getCurPage', func_get_args(), $pluginInfo) : parent::getCurPage($displacement);
    }

    /**
     * {@inheritdoc}
     */
    public function getLastPageNumber()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getLastPageNumber');
        return $pluginInfo ? $this->___callPlugins('getLastPageNumber', func_get_args(), $pluginInfo) : parent::getLastPageNumber();
    }

    /**
     * {@inheritdoc}
     */
    public function getPageSize()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getPageSize');
        return $pluginInfo ? $this->___callPlugins('getPageSize', func_get_args(), $pluginInfo) : parent::getPageSize();
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstItem()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getFirstItem');
        return $pluginInfo ? $this->___callPlugins('getFirstItem', func_get_args(), $pluginInfo) : parent::getFirstItem();
    }

    /**
     * {@inheritdoc}
     */
    public function getLastItem()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getLastItem');
        return $pluginInfo ? $this->___callPlugins('getLastItem', func_get_args(), $pluginInfo) : parent::getLastItem();
    }

    /**
     * {@inheritdoc}
     */
    public function getItems()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getItems');
        return $pluginInfo ? $this->___callPlugins('getItems', func_get_args(), $pluginInfo) : parent::getItems();
    }

    /**
     * {@inheritdoc}
     */
    public function getColumnValues($colName)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getColumnValues');
        return $pluginInfo ? $this->___callPlugins('getColumnValues', func_get_args(), $pluginInfo) : parent::getColumnValues($colName);
    }

    /**
     * {@inheritdoc}
     */
    public function getItemsByColumnValue($column, $value)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getItemsByColumnValue');
        return $pluginInfo ? $this->___callPlugins('getItemsByColumnValue', func_get_args(), $pluginInfo) : parent::getItemsByColumnValue($column, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getItemByColumnValue($column, $value)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getItemByColumnValue');
        return $pluginInfo ? $this->___callPlugins('getItemByColumnValue', func_get_args(), $pluginInfo) : parent::getItemByColumnValue($column, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function addItem(\Magento\Framework\DataObject $item)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addItem');
        return $pluginInfo ? $this->___callPlugins('addItem', func_get_args(), $pluginInfo) : parent::addItem($item);
    }

    /**
     * {@inheritdoc}
     */
    public function removeItemByKey($key)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'removeItemByKey');
        return $pluginInfo ? $this->___callPlugins('removeItemByKey', func_get_args(), $pluginInfo) : parent::removeItemByKey($key);
    }

    /**
     * {@inheritdoc}
     */
    public function removeAllItems()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'removeAllItems');
        return $pluginInfo ? $this->___callPlugins('removeAllItems', func_get_args(), $pluginInfo) : parent::removeAllItems();
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'clear');
        return $pluginInfo ? $this->___callPlugins('clear', func_get_args(), $pluginInfo) : parent::clear();
    }

    /**
     * {@inheritdoc}
     */
    public function walk($callback, array $args = [])
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'walk');
        return $pluginInfo ? $this->___callPlugins('walk', func_get_args(), $pluginInfo) : parent::walk($callback, $args);
    }

    /**
     * {@inheritdoc}
     */
    public function each($objMethod, $args = [])
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'each');
        return $pluginInfo ? $this->___callPlugins('each', func_get_args(), $pluginInfo) : parent::each($objMethod, $args);
    }

    /**
     * {@inheritdoc}
     */
    public function setDataToAll($key, $value = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setDataToAll');
        return $pluginInfo ? $this->___callPlugins('setDataToAll', func_get_args(), $pluginInfo) : parent::setDataToAll($key, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function setCurPage($page)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setCurPage');
        return $pluginInfo ? $this->___callPlugins('setCurPage', func_get_args(), $pluginInfo) : parent::setCurPage($page);
    }

    /**
     * {@inheritdoc}
     */
    public function setPageSize($size)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setPageSize');
        return $pluginInfo ? $this->___callPlugins('setPageSize', func_get_args(), $pluginInfo) : parent::setPageSize($size);
    }

    /**
     * {@inheritdoc}
     */
    public function setItemObjectClass($className)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setItemObjectClass');
        return $pluginInfo ? $this->___callPlugins('setItemObjectClass', func_get_args(), $pluginInfo) : parent::setItemObjectClass($className);
    }

    /**
     * {@inheritdoc}
     */
    public function getNewEmptyItem()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getNewEmptyItem');
        return $pluginInfo ? $this->___callPlugins('getNewEmptyItem', func_get_args(), $pluginInfo) : parent::getNewEmptyItem();
    }

    /**
     * {@inheritdoc}
     */
    public function toXml()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'toXml');
        return $pluginInfo ? $this->___callPlugins('toXml', func_get_args(), $pluginInfo) : parent::toXml();
    }

    /**
     * {@inheritdoc}
     */
    public function toArray($arrRequiredFields = [])
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'toArray');
        return $pluginInfo ? $this->___callPlugins('toArray', func_get_args(), $pluginInfo) : parent::toArray($arrRequiredFields);
    }

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'toOptionArray');
        return $pluginInfo ? $this->___callPlugins('toOptionArray', func_get_args(), $pluginInfo) : parent::toOptionArray();
    }

    /**
     * {@inheritdoc}
     */
    public function toOptionHash()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'toOptionHash');
        return $pluginInfo ? $this->___callPlugins('toOptionHash', func_get_args(), $pluginInfo) : parent::toOptionHash();
    }

    /**
     * {@inheritdoc}
     */
    public function getItemById($idValue)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getItemById');
        return $pluginInfo ? $this->___callPlugins('getItemById', func_get_args(), $pluginInfo) : parent::getItemById($idValue);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getIterator');
        return $pluginInfo ? $this->___callPlugins('getIterator', func_get_args(), $pluginInfo) : parent::getIterator();
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'count');
        return $pluginInfo ? $this->___callPlugins('count', func_get_args(), $pluginInfo) : parent::count();
    }

    /**
     * {@inheritdoc}
     */
    public function getFlag($flag)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getFlag');
        return $pluginInfo ? $this->___callPlugins('getFlag', func_get_args(), $pluginInfo) : parent::getFlag($flag);
    }

    /**
     * {@inheritdoc}
     */
    public function setFlag($flag, $value = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setFlag');
        return $pluginInfo ? $this->___callPlugins('setFlag', func_get_args(), $pluginInfo) : parent::setFlag($flag, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function hasFlag($flag)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'hasFlag');
        return $pluginInfo ? $this->___callPlugins('hasFlag', func_get_args(), $pluginInfo) : parent::hasFlag($flag);
    }
}
