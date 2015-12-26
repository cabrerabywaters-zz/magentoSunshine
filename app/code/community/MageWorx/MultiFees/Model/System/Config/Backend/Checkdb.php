<?php
/**
 * MageWorx
 * Multi Fees Extension
 *
 * @category   MageWorx
 * @package    MageWorx_MultiFees
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

class MageWorx_MultiFees_Model_System_Config_Backend_Checkdb extends Mage_Core_Model_Config_Data
{
    /**
     * @return Mage_Core_Model_Abstract|void
     */
    protected function _afterSave() {        
        try {                
            // check db setup
            $resource = Mage::getSingleton('core/resource');
            $connection = $resource->getConnection('core_write');
            if (!$connection->tableColumnExists($resource->getTableName('mageworx_multifees/fee'), 'is_onetime')) {
                $connection->delete($resource->getTableName('core/resource'), "code =  'mageworx_multifees_setup'");
            }
        } catch (Exception $e) {}        
    }
}
