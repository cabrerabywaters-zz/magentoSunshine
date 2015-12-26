<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Checkout
 * @copyright   Copyright (c) 2014 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Magestore_Webpos_Block_Cart_Totals extends Mage_Checkout_Block_Cart_Totals
{
    /* Mr Jack rewrite renderToal*/
    public function renderTotal($total, $area = null, $colspan = 1)
    {
        $code = $total->getCode();
        if ($total->getAs()) {
            $code = $total->getAs();
        }
        if($code == 'subtotal')
            return $this->_getTotalRenderer($code)
                ->setTotal($total)
                ->setColspan($colspan)
                ->setRenderingArea(is_null($area) ? -1 : $area)
                ->setTemplate('webpos/webpos/review/tax/subtotal.phtml')
                ->toHtml();
        if($code == 'discount')
           return $this->_getTotalRenderer($code)
                ->setTotal($total)
                ->setColspan($colspan)
                ->setRenderingArea(is_null($area) ? -1 : $area)
                ->setTemplate('webpos/webpos/review/tax/discount.phtml')
                ->toHtml();
        if($code == 'tax')
           return $this->_getTotalRenderer($code)
                ->setTotal($total)
                ->setColspan($colspan)
                ->setRenderingArea(is_null($area) ? -1 : $area)
                ->setTemplate('webpos/webpos/review/tax/tax.phtml')
                ->toHtml();
        if($code == 'shipping')
           return $this->_getTotalRenderer($code)
                ->setTotal($total)
                ->setColspan($colspan)
                ->setRenderingArea(is_null($area) ? -1 : $area)
                ->setTemplate('webpos/webpos/review/tax/shipping.phtml')
                ->toHtml();
        if($code == 'grand_total')
           return $this->_getTotalRenderer($code)
                ->setTotal($total)
                ->setColspan($colspan)
                ->setRenderingArea(is_null($area) ? -1 : $area)
                ->setTemplate('webpos/webpos/review/tax/grandtotal.phtml')
                ->toHtml();
		// Changed By Adam (21/08/2015): using affiliate coupon in webpos
		if($code == 'affiliateplus' || $code == 'affiliateplusaftertax')
           return $this->_getTotalRenderer($code)
                ->setTotal($total)
                ->setColspan($colspan)
                ->setRenderingArea(is_null($area) ? -1 : $area)
                ->setTemplate('webpos/webpos/review/tax/affiliateplus.phtml')
                ->toHtml();
		
        return $this->_getTotalRenderer($code)
                ->setTotal($total)
                ->setColspan($colspan)
                ->setRenderingArea(is_null($area) ? -1 : $area)
				->setTemplate('webpos/webpos/review/total.phtml')
                ->toHtml();
		
    }
    /**/
}
