<?php /**/
namespace Olegnax\Athlete2\Model\Config\Settings\Footer;
use Magento\Framework\Option\ArrayInterface;
use Magento\Framework\View\Asset\Repository;

class CopyrightLayout implements ArrayInterface
{
    protected $_assetRepo;

    public function __construct(
        Repository $assetRepo
    ) {
        $this->_assetRepo = $assetRepo;
    }

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
            '1' => $this->_assetRepo->getUrl( 'Olegnax_Athlete2::images/copyright-layout-01.png' ),
            '2' => $this->_assetRepo->getUrl( 'Olegnax_Athlete2::images/copyright-layout-02.png' ),
        ];
    }
}
