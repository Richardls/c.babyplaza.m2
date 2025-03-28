<?php
namespace Magento\Cms\Model\Wysiwyg\Validator;

/**
 * Interceptor class for @see \Magento\Cms\Model\Wysiwyg\Validator
 */
class Interceptor extends \Magento\Cms\Model\Wysiwyg\Validator implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Validator\HTML\WYSIWYGValidatorInterface $validator, \Magento\Framework\Message\ManagerInterface $messages, \Magento\Framework\App\Config\ScopeConfigInterface $config, \Psr\Log\LoggerInterface $logger, \Magento\Framework\Message\Factory $messageFactory)
    {
        $this->___init();
        parent::__construct($validator, $messages, $config, $logger, $messageFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function validate(string $content) : void
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'validate');
        $pluginInfo ? $this->___callPlugins('validate', func_get_args(), $pluginInfo) : parent::validate($content);
    }
}
