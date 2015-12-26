<?php
/**
 * Magoch.com
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
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @category   Administration
 * @package    Magoch_Externlinks
 * @copyright  Copyright (c) 2010-2011  Magoch (http://www.magoch.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author    Igor Ocheretnyi <support@magoch.com>
*/
class Magoch_Externlinks_Block_Adminhtml_Externlinks extends Mage_Adminhtml_Block_Widget_Form {

	public function __construct() { 
		$id		=  $this->getRequest()->getParam('id');
		$uri	= Mage::getStoreConfig("externlinks/default/menu_link$id");

		// validate input parameter
        if (!Zend_Uri::check($uri)) {
			$uri = '';
            //$this->addException("Expecting a valid 'uri' parameter");
        }
		
		$this->setTmpUrl($uri);
	}	
}