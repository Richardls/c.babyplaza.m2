<?php /**/
namespace Olegnax\Athlete2\Model\Config\Settings\Header;
use Magento\Framework\Option\ArrayInterface;

class HeaderBannerMode implements ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 'always', 'label' => __('Always')],
            ['value' => 'once', 'label' => __('Once')]
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
