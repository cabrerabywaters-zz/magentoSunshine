<?php
/**
 * Created by Ravinder (Rav).
 * User    : Ravinder (Rav)
 * Company : Codewix Development
 * Email   : codewix@gmail.com
 * Date    : 16/12/14
 * Time    : 6:17 AM
 */

class Codewix_Logo_Model_System_Config_Backend_Logo extends Mage_Adminhtml_Model_System_Config_Backend_Image {

    /**
     * The tail part of directory path for uploading
     */
    const UPLOAD_DIR                = 'frontend/base/default';

    /**
     * Token for the root part of directory path for uploading
     */
    const UPLOAD_ROOT_TOKEN         = 'system/filesystem/skin';

    /**
     * Upload max file size in kilobytes
     *
     * @var int
     */
    protected $_maxFileSize         = 2048;

    /**
     * Return path to directory for upload file
     *
     * @return string
     */
    protected function _getUploadDir()
    {
        $uploadDir  = $this->_appendScopeInfo(self::UPLOAD_DIR);
        $uploadRoot = $this->_getUploadRoot(self::UPLOAD_ROOT_TOKEN);
        $uploadDir  = $uploadRoot . DS . $uploadDir;
        return $uploadDir;
    }

    /**
     * Return the root part of directory path for uploading
     *
     * @var string
     * @return string
     */
    protected function _getUploadRoot($token)
    {
        return Mage::getBaseDir('skin');
    }

    /**
     * Makes a decision about whether to add info about the scope
     *
     * @return boolean
     */
    protected function _addWhetherScopeInfo()
    {
        return true;
    }

    /**
     * Save uploaded file before saving config value
     *
     * Save changes and delete file if "delete" option passed
     *
     * @return Codewix_Logo_Model_System_Config_Backend_Logo
     */
    protected function _beforeSave()
    {
        $value       = $this->getValue();
        $deleteFlag  = (is_array($value) && !empty($value['delete']));
        $fileTmpName = $_FILES['groups']['tmp_name'][$this->getGroupId()]['fields'][$this->getField()]['value'];

        if ($this->getOldValue() && ($fileTmpName || $deleteFlag)) {
            $io = new Varien_Io_File();
            $io->rm($this->_getUploadRoot(self::UPLOAD_ROOT_TOKEN) . DS . self::UPLOAD_DIR . DS . $this->getOldValue());
        }
        return parent::_beforeSave();
    }

}