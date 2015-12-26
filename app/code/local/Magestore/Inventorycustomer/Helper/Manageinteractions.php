<?php

/**
 * Magestore
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the Magestore.com license that is
 * available through the world-wide-web at this URL:
 * http://www.magestore.com/license-agreement.html
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category    Magestore
 * @package     Magestore_Inventorycustomer
 * @copyright   Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */

/**
 * Inventorycustomer Helper
 * 
 * @category    Magestore
 * @package     Magestore_Inventorycustomer
 * @author      Magestore Developer
 */
class Magestore_Inventorycustomer_Helper_Manageinteractions extends Mage_Core_Helper_Abstract {

    public function getListInteractions() {
        $interactionCollection = Mage::getModel('inventorycustomer/customerinteraction')->getCollection();

        $interactionCollection = $this->joinEavTablesIntoCollection($interactionCollection, 'customer_id', 'customer');
        
        $interactionCollection->getSelect()->columns(array('interaction_created_at' => 'main_table.created_at'));

        return $interactionCollection;
    }

    /**
     * This assumes that the foreign key is the entity id of the eav table.
     * $collection is a collection object of a flat table.
     * $mainTableForeignKey is the name of the foreign key to the eav table.
     * $eavType is the type of entity (the entity_type_code in eav_entity_type)
     */
    public function joinEavTablesIntoCollection($collection, $mainTableForeignKey, $eavType) {

        $entityType = Mage::getModel('eav/entity_type')->loadByCode($eavType);
        $attributes = $entityType->getAttributeCollection();
        $entityTable = $collection->getTable($entityType->getEntityTable());

        //Use an incremented index to make sure all of the aliases for the eav attribute tables are unique.
        $index = 1;
        foreach ($attributes->getItems() as $attribute) {
            $alias = 'table' . $index;
            if ($attribute->getBackendType() != 'static') {
                $table = $entityTable . '_' . $attribute->getBackendType();
                $field = $alias . '.value';
                $collection->getSelect()
                        ->joinLeft(array($alias => $table), 'main_table.' . $mainTableForeignKey . ' = ' . $alias . '.entity_id and ' . $alias . '.attribute_id = ' . $attribute->getAttributeId(), array($attribute->getAttributeCode() => $field)
                );
            }
            $index++;
        }
        //Join in all of the static attributes by joining the base entity table.
        $collection->getSelect()->joinLeft($entityTable, 'main_table.' . $mainTableForeignKey . ' = ' . $entityTable . '.entity_id');

        return $collection;
    }

}
