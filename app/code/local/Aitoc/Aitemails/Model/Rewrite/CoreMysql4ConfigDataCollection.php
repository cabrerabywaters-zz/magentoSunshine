<?php
/**
 * Email Template Manager
 *
 * @category:    Aitoc
 * @package:     Aitoc_Aitemails
 * @version      2.0.15
 * @license:     GJkOrjFJ3FDd0bwCKiZv6ZcnFSqCjq1hKOLxXNQDVB
 * @copyright:   Copyright (c) 2015 AITOC, Inc. (http://www.aitoc.com)
 */
class Aitoc_Aitemails_Model_Rewrite_CoreMysql4ConfigDataCollection extends Mage_Core_Model_Mysql4_Config_Data_Collection
{
    public function addScopeMultiPathFilter($scope, $scopeId, $pathes)
    {
        if (!is_array($pathes))
        {
            $pathes = array($pathes);
        }
        $this->_select
            ->where('scope=?', $scope)
            ->where('scope_id=?', $scopeId)
            ->where('REPLACE(path, "/", "_") IN ( ' . implode(',', $pathes) . ' )');
        return $this;
    }
    
    public function addScopePathFilter($scope, $scopeId, $path)
    {
        $this->_select
            ->where('scope=?', $scope)
            ->where('scope_id=?', $scopeId)
            ->where('path = ?', $path);
        return $this;
    }
}