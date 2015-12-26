<?php
/**
 * Created by PhpStorm.
 * User: Quoc Viet
 * Date: 08/07/2015
 * Time: 8:40 SA
 */
class Magestore_Webpos_Helper_Permission extends Mage_Core_Helper_Abstract {
    protected function _getSession(){
        return Mage::getSingleton('webpos/session');
    }
    public function getCurrentUser() {
        $session = $this->_getSession();
        $userId= $session->getId();
        if (isset($userId)&&($userId>0)) {
            return $userId;
        } else {
            return $userId;
        }
    }
    //check permission
    public function isPermission($userId,$permissionId) {
        if ($userId>0) {
            $userModel = Mage::getModel('webpos/user')->load($userId);
            if ($userModel->getUserId()) {
                $roleId = $userModel->getRoleId();
                if ($roleId > 0) {
                    $roleModel = Mage::getModel('webpos/role')->load($roleId);
                    $permissionIds = $roleModel->getPermissionIds();
                    $statusRole = $roleModel->getActive();
                    if ($statusRole == 1) {
                        $permissionArray = explode(',', $permissionIds);
                        foreach ($permissionArray as $permission) {
                            if ($permission == $permissionId ||
                                $permission==Magestore_Webpos_Model_Source_Adminhtml_Permission::ALL_PERMISSION) {
                                return true;
                            }
                        }
                    }
                }
            }
        }
        return false;
    }
    public function isCreateOrder($userId) {
        $isCreateOrder =$this->isPermission($userId,Magestore_Webpos_Model_Source_Adminhtml_Permission::CREATE_ORDER);
        if ($isCreateOrder) {
            return true;
        } else {
            return false;
        }
    }

    public function isAllPermission($userId) {
        return $this->isPermission($userId,Magestore_Webpos_Model_Source_Adminhtml_Permission::ALL_PERMISSION);
    }
    public function isOrderThisUser($userId) {
        $isPermissionThisUser = $this->isPermission($userId,Magestore_Webpos_Model_Source_Adminhtml_Permission::MANAGE_ORDER_THIS_USER);
        $isViewThisUser = $this->isPermission($userId,Magestore_Webpos_Model_Source_Adminhtml_Permission::VIEW_ORDER_THIS_USER);
        if ($isPermissionThisUser || $isViewThisUser) {
            return true;
        } else {
            return false;
        }
    }
    public function isOtherStaff($userId) {
        $isManageOther=$this->isPermission($userId,Magestore_Webpos_Model_Source_Adminhtml_Permission::MANAGE_ORDER_OTHER_STAFF);
        $isOtherStaff= $this->isPermission($userId,Magestore_Webpos_Model_Source_Adminhtml_Permission::VIEW_ORDER_OTHER_STAFF);
        if ($isManageOther || $isOtherStaff) {
            return true;
        } else {
            return false;
        }
    }
    public function isAllOrder($userId) {
        $isManagePermission=$this->isPermission($userId,Magestore_Webpos_Model_Source_Adminhtml_Permission::MANAGE_ORDER_ALL_ORDER);
        $isViewAll= $this->isPermission($userId,Magestore_Webpos_Model_Source_Adminhtml_Permission::VIEW_ORDER_ALL_ORDER);
        if ($isManagePermission || $isViewAll) {
            return true;
        } else {
            return false;
        }
    }
    public function manageByThisUser($userId) {
        $isPermissionThisUser = $this->isPermission($userId,Magestore_Webpos_Model_Source_Adminhtml_Permission::MANAGE_ORDER_THIS_USER);
        $isPermissionAll= $this->isPermission($userId,Magestore_Webpos_Model_Source_Adminhtml_Permission::MANAGE_ORDER_ALL_ORDER);
        if ($isPermissionThisUser||$isPermissionAll) {
            return true;
        }
        return false;
    }
    public function manageByOtherStaff($userId) {
        $isPermissionOtherStaff = $this->isPermission($userId,Magestore_Webpos_Model_Source_Adminhtml_Permission::MANAGE_ORDER_OTHER_STAFF);
        $isPermissionAll= $this->isPermission($userId,Magestore_Webpos_Model_Source_Adminhtml_Permission::MANAGE_ORDER_ALL_ORDER);
        if ($isPermissionOtherStaff||$isPermissionAll) {
            return true;
        }
        return false;
    }
    public function manageByAllOrder($userId) {
        return $this->isPermission($userId,Magestore_Webpos_Model_Source_Adminhtml_Permission::MANAGE_ORDER_ALL_ORDER);
    }
    public function viewAndManageThisUser($userId) {
        $isView=$this->isOrderThisUser($userId);
        $isManage = $this->manageByThisUser($userId);
        if ($isView&& $isManage) {
            return true;
        }
        return false;
    }
    public function viewAndManageOtherUser($userId) {
        $isView=$this->isOtherStaff($userId);
        $isManage = $this->manageByOtherStaff($userId);
        if ($isView&& $isManage) {
            return true;
        }
        return false;
    }
    public function viewAndManageAllUser($userId) {
        $isView=$this->isAllOrder($userId);
        $isManage = $this->manageByAllOrder($userId);
        if ($isView&& $isManage) {
            return true;
        }
        return false;
    }
    public function isManage($userId) {
        $viewAndManageThisUser=$this->manageByThisUser($userId);
        $viewAndManageOtherUser=$this->manageByOtherStaff($userId);
        $viewAndManageAllUser=$this->manageByAllOrder($userId);
        if ($viewAndManageThisUser||$viewAndManageOtherUser ||$viewAndManageAllUser) {
            return true;
        }
        return false;
    }

    public function isOrderOfThisUser($userId,$orderId) {
        $order = Mage::getModel('sales/order')->load($orderId);
        $userCreatedOrder = $order->getWebposAdminId();
        if ($userId>0 && $userId==$userCreatedOrder) {
            return true;
        } else {
            return false;
        }
    }
    public function isOrderOfOtherUser($userId,$orderId) {
        $order = Mage::getModel('sales/order')->load($orderId);
        $userCreatedOrder = $order->getWebposAdminId();
        if ($userId>0 && $userId!=$userCreatedOrder) {
            return true;
        } else {
            return false;
        }
    }
    public function isOrderOfWebpos($orderId) {
        $order = Mage::getModel('sales/order')->load($orderId);
        $userCreatedOrder = $order->getWebposAdminId();
        if ($userCreatedOrder>0) {
            return true;
        } else {
            return false;
        }
    }

    public function canManageOrder($userId,$orderId) {
        $manageByThisUser = $this->manageByThisUser($userId);
        $isOrderOfThisUser = $this->isOrderOfThisUser($userId,$orderId);
        $manageByOtherStaff = $this->manageByOtherStaff($userId);
        $isOrderOfOtherStaff = $this->isOrderOfOtherUser($userId,$orderId);
        $isManageAllOrder = $this->manageByAllOrder($userId);
        $isOrderOfWebpos = $this->isOrderOfWebpos($orderId);
        if (($manageByThisUser && $isOrderOfThisUser)|| ($manageByOtherStaff&&$isOrderOfOtherStaff) || ($isManageAllOrder&&$isOrderOfWebpos)) {
            return true;
        }

        return false;
    }



    public function approvePermission($userId,$permissionId) {
        $isPermission=$this->isPermission($userId,$permissionId);
        if ($isPermission==false) {
            Mage::getSingleton('core/session')->addError('Error Message');
        } else {

        }
        return $this;
    }
}