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
class Magoch_Externlinks_Block_Adminhtml_Page_Menu extends Mage_Adminhtml_Block_Page_Menu {

    protected $extraMenuLinks = 6;

    /**
     * Recursive Build Menu array
     *
     * @param Varien_Simplexml_Element $parent
     * @param string $path
     * @param int $level
     * @return array
     */
    protected function _buildMenuArray(Varien_Simplexml_Element $parent=null, $path='', $level=0) {
        if (is_null($parent)) {
            $parent = Mage::getSingleton('admin/config')->getAdminhtmlConfig()->getNode('menu');
        }

        $parentArr = array();
        $sortOrder = 0;
        foreach ($parent->children() as $childName => $child) {
            if (1 == $child->disabled) {
                continue;
            }

            $aclResource = 'admin/' . ($child->resource ? (string) $child->resource : $path . $childName);
            if (!$this->_checkAcl($aclResource)) {
                continue;
            }

            if ($child->depends && !$this->_checkDepends($child->depends)) {
                continue;
            }

            $menuArr = array();

            $menuArr['label'] = $this->_getHelperValue($child);

            $menuArr['sort_order'] = $child->sort_order ? (int) $child->sort_order : $sortOrder;

            if ($child->action) {
                $menuArr['url'] = $this->_url->getUrl((string) $child->action, array('_cache_secret_key' => true));
            } else {
                $menuArr['url'] = '#';
                $menuArr['click'] = 'return false';
            }

            $menuArr['active'] = ($this->getActive() == $path . $childName)
                    || (strpos($this->getActive(), $path . $childName . '/') === 0);

            $menuArr['level'] = $level;

            if ($child->children) {
                $menuArr['children'] = $this->_buildMenuArray($child->children, $path . $childName . '/', $level + 1);
            }

            if (Mage::getStoreConfig("externlinks/default/enabled")) {
                if ($childName == 'dashboard') {

                    for ($i = 1, $n = $this->extraMenuLinks; $i <= $n; $i++) {
                        $link   = Mage::getStoreConfig("externlinks/default/menu_link$i");
                        $title  = Mage::getStoreConfig("externlinks/default/menu_title$i");

                        $link   = trim($link);
                        $title  = trim($title);

                        if ($link && $title) {

                            // validate input parameter
                            if (!Zend_Uri::check($link)) { 
                                continue;
                                //$this->addException("Expecting a valid 'uri' parameter");
                            }

                            $mArr['label'] = $title;
                            $mArr['sort_order'] = $i * 10;
                            $mArr['url'] = $this->getUrl('externlinks/adminhtml_index/index/id/' . $i);
                            $mArr['active'] = 0;
                            $mArr['level']  = 1;
                            $menuArr['children']["sub_$i"] = $mArr;

                            unset($mArr);
                        }
                    }
                }
            }
            $parentArr[$childName] = $menuArr;
            $sortOrder++;
        }

        uasort($parentArr, array($this, '_sortMenu'));

        while (list($key, $value) = each($parentArr)) {
            $last = $key;
        }
        if (isset($last)) {
            $parentArr[$last]['last'] = true;
        }

        return $parentArr;
    }

}