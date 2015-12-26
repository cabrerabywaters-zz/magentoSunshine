<?php
/* DO NOT MODIFY THIS FILE! THIS IS TEMPORARY FILE AND WILL BE RE-GENERATED AS SOON AS CACHE CLEARED. */

class Aitoc_Aitemails_Model_Rewrite_CoreEmailTemplate extends Mage_Core_Model_Email_Template
{
    
    public function sendTransactional($templateId, $sender, $email, $name, $vars=array(), $storeId=null)
    {
        $templatePath = Mage::helper('aitemails')->getPathByEmailTemplateCode('sales_email_order_template');
        $collection  = Mage::getResourceSingleton('aitemails/aittemplate_collection');
        $aCollection = $collection->load()->toArray();
        $aCollection = $aCollection['items'];
        
        $this->load($templateId);
        
        foreach ($aCollection as $template)
        {
            $templatePath = Mage::helper('aitemails')->getPathByEmailTemplateCode($template['code']);
            if (!$this->getId() && is_numeric($templateId)) 
            {
                $config_value = Mage::getStoreConfig($templatePath);

                if ($config_value == $templateId)
                {
                    $templateId = $template['code'];
                }
            }
        }
        
        $this->setAitmailsStoreId($storeId);
        return parent::sendTransactional($templateId, $sender, $email, $name, $vars, $storeId);
    }
    
    protected function _afterSave()
    {
        $res = parent::_afterSave();
        $observer = new Varien_Event_Observer();
        $observer->setObject($this);
        Mage::getSingleton('aitemails/observer')->performSaveCommitAfter($observer);
        return $res;
    }
    
    public function getAitmailsStoreId()
    {
        $storeId = $this->getData('aitmails_store_id');
        if (!$storeId)
        {
            $storeId = Mage::app()->getStore()->getId();
        }
        return $storeId;
    }
    
    /**
     * Send mail to recipient
     *
     * @param   string      $email          E-mail
     * @param   string|null $name         receiver name
     * @param   array       $variables    template variables
     * @return  boolean
     **/
    public function send($email, $name=null, array $variables = array())
    {
        if(!$this->isValidForSend()) {
            return false;
        }
        
        if (version_compare(Mage::getVersion(), '1.4.2', '>='))
        {
            $emails = array_values((array)$email);
            $names = is_array($name) ? $name : (array)$name;
            $names = array_values($names);
            
            foreach ($emails as $key => $email) {
                if (!isset($names[$key])) {
                    $names[$key] = substr($email, 0, strpos($email, '@'));
                }
            }
            $variables['email'] = $emails;
            $variables['name'] = $names;
        }
        else
        {
            if (is_null($name))
            {
                $name = substr($email, 0, strpos($email, '@'));
            }
            $variables['email'] = $email;
            $variables['name'] = $name;
        }

        ini_set('SMTP', Mage::getStoreConfig('system/smtp/host'));
        ini_set('smtp_port', Mage::getStoreConfig('system/smtp/port'));

        $mail = $this->getMail();

        $setReturnPath = Mage::getStoreConfig(self::XML_PATH_SENDING_SET_RETURN_PATH);
        switch ($setReturnPath) {
            case 1:
                $returnPathEmail = $this->getSenderEmail();
                break;
            case 2:
                $returnPathEmail = Mage::getStoreConfig(self::XML_PATH_SENDING_RETURN_PATH_EMAIL);
                break;
            default:
                $returnPathEmail = null;
                break;
        }

        if ($returnPathEmail !== null)
        {
            if (version_compare(Mage::getVersion(), '1.4.2', '>='))
            {
                $mailTransport = new Zend_Mail_Transport_Sendmail($returnPathEmail);
                Zend_Mail::setDefaultTransport($mailTransport);
            } else {
                $mail->setReturnPath($returnPathEmail);    
            }                
        }
 
        if (version_compare(Mage::getVersion(), '1.4.2', '>='))
        {
            foreach ($emails as $key => $email) 
            {
                $mail->addTo($email, '=?utf-8?B?' . base64_encode($names[$key]) . '?=');
            }
        }
        else
        {
            if (is_array($email)) 
            {
                foreach ($email as $emailOne) 
                {
                    $mail->addTo($emailOne, $name);
                }
            } 
            else
            {
                $mail->addTo($email, '=?utf-8?B?' . base64_encode($name) . '?=');
            }
        }

        $this->setUseAbsoluteLinks(true);
        $text = $this->getProcessedTemplate($variables, true);
        
        if($this->isPlain()) {
            $mail->setBodyText($text);
        } else {
            $html2plain = new Aitoc_Html2Text($text);
            $textplain = $html2plain->get_text();
            $mail->setBodyText($textplain);
            
            // adding html tag
            if (false === strpos($text, '<html>'))
            {
                $text = '<html>' . $text;
            }
            if (false === strpos($text, '</html>'))
            {
                $text = $text . '</html>';
            }
            
            $mail->setBodyHTML($text);
        }

        $mail->setSubject('=?utf-8?B?'.base64_encode($this->getProcessedTemplateSubject($variables)).'?=');
        $mail->setFrom($this->getSenderEmail(), $this->getSenderName());
        
        // adding attachments
        $attachmentCollection = Mage::getModel('aitemails/aitattachment')->getTemplateAttachments($this->getId());
        if (count($attachmentCollection) > 0)
        {
            foreach ($attachmentCollection as $attachment)
            {
                if ($attachment->getAttachmentFile())
                {
                    $sFileExt = substr($attachment->getAttachmentFile(), strrpos($attachment->getAttachmentFile(), '.'));
                    if ($attachment->getData('store_title'))
                    {
                        $sFileName = $this->normalizeFilename($attachment->getData('store_title')) . $sFileExt;
                    } else 
                    {
                        $sFileName = substr($attachment->getAttachmentFile(), 1 + strrpos($attachment->getAttachmentFile(), '/'));
                    }
                    $att = $mail->createAttachment(file_get_contents(Aitoc_Aitemails_Model_Aitattachment::getBasePath() . $attachment->getAttachmentFile()));
                    $att->filename = $sFileName;
                }
            }
        }

        try
        {
            $mail->send(); // Zend_Mail warning..
            $this->_mail = null;
        }
        catch (Exception $e)
        {
            return false;
        }
        
        return true;
    }
    
    public function normalizeFilename($sFileName)
    {
        $sFileName = preg_replace('@[^a-zA-Z0-9_]@', '_', $sFileName);
        $sFileName = preg_replace('@_+@', '_', $sFileName);
        return $sFileName;
    }
}


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
 * @package     Mage_Core
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Template model
 *
 * Example:
 *
 * // Loading of template
 * $emailTemplate  = Mage::getModel('core/email_template')
 *    ->load(Mage::getStoreConfig('path_to_email_template_id_config'));
 * $variables = array(
 *    'someObject' => Mage::getSingleton('some_model')
 *    'someString' => 'Some string value'
 * );
 * $emailTemplate->send('some@domain.com', 'Name Of User', $variables);
 *
 * @method Mage_Core_Model_Resource_Email_Template _getResource()
 * @method Mage_Core_Model_Resource_Email_Template getResource()
 * @method string getTemplateCode()
 * @method Mage_Core_Model_Email_Template setTemplateCode(string $value)
 * @method string getTemplateText()
 * @method Mage_Core_Model_Email_Template setTemplateText(string $value)
 * @method string getTemplateStyles()
 * @method Mage_Core_Model_Email_Template setTemplateStyles(string $value)
 * @method int getTemplateType()
 * @method Mage_Core_Model_Email_Template setTemplateType(int $value)
 * @method string getTemplateSubject()
 * @method Mage_Core_Model_Email_Template setTemplateSubject(string $value)
 * @method string getTemplateSenderName()
 * @method Mage_Core_Model_Email_Template setTemplateSenderName(string $value)
 * @method string getTemplateSenderEmail()
 * @method Mage_Core_Model_Email_Template setTemplateSenderEmail(string $value)
 * @method string getAddedAt()
 * @method Mage_Core_Model_Email_Template setAddedAt(string $value)
 * @method string getModifiedAt()
 * @method Mage_Core_Model_Email_Template setModifiedAt(string $value)
 * @method string getOrigTemplateCode()
 * @method Mage_Core_Model_Email_Template setOrigTemplateCode(string $value)
 * @method string getOrigTemplateVariables()
 * @method Mage_Core_Model_Email_Template setOrigTemplateVariables(string $value)
 *
 * @category    Mage
 * @package     Mage_Core
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Magestore_Pdfinvoiceplus_Model_Email_Template extends Aitoc_Aitemails_Model_Rewrite_CoreEmailTemplate
{
    protected $_filedata = array(); //(by dw)    
    /**
     * Send mail to recipient
     *
     * @param   array|string       $email        E-mail(s)
     * @param   array|string|null  $name         receiver name(s)
     * @param   array              $variables    template variables
     * @return  boolean
     **/
    public function send($email, $name = null, array $variables = array())
    {
        if (!$this->isValidForSend()) {
            Mage::logException(new Exception('This letter cannot be sent.')); // translation is intentionally omitted
            return false;
        }

        $emails = array_values((array)$email);
        $names = is_array($name) ? $name : (array)$name;
        $names = array_values($names);
        foreach ($emails as $key => $email) {
            if (!isset($names[$key])) {
                $names[$key] = substr($email, 0, strpos($email, '@'));
            }
        }

        $variables['email'] = reset($emails);
        $variables['name'] = reset($names);

        ini_set('SMTP', Mage::getStoreConfig('system/smtp/host'));
        ini_set('smtp_port', Mage::getStoreConfig('system/smtp/port'));

        $mail = $this->getMail();

        $setReturnPath = Mage::getStoreConfig(self::XML_PATH_SENDING_SET_RETURN_PATH);
        switch ($setReturnPath) {
            case 1:
                $returnPathEmail = $this->getSenderEmail();
                break;
            case 2:
                $returnPathEmail = Mage::getStoreConfig(self::XML_PATH_SENDING_RETURN_PATH_EMAIL);
                break;
            default:
                $returnPathEmail = null;
                break;
        }

        if ($returnPathEmail !== null) {
            $mailTransport = new Zend_Mail_Transport_Sendmail("-f".$returnPathEmail);
            Zend_Mail::setDefaultTransport($mailTransport);
        }

        foreach ($emails as $key => $email) {
           $mail->addTo($email, '=?utf-8?B?' . base64_encode($names[$key]) . '?=');            
        }

        $this->setUseAbsoluteLinks(true);
        $text = $this->getProcessedTemplate($variables, true);

        if($this->isPlain()) {
            $mail->setBodyText($text);
        } else {
            $mail->setBodyHTML($text);
        }

        $mail->setSubject('=?utf-8?B?' . base64_encode($this->getProcessedTemplateSubject($variables)) . '?=');
        $mail->setFrom($this->getSenderEmail(), $this->getSenderName());

        //(by dw)
        //start
        $atInfo = $this->getEmAttachments(); 	
        if(!empty($atInfo))
        {			    	
	    	$_file = $mail->createAttachment($atInfo['fileContents']);
	    	$_file->type = 'application/pdf';
			$_file->filename = $atInfo['fileName'];
        }
		//end
		
        try {
            $mail->send();
            $this->_mail = null;
        }
        catch (Exception $e) {
            $this->_mail = null;
            Mage::logException($e);
            return false;
        }

        return true;
    }
    //(by dw)
    //start
    public function setEmAttachments($attachments)
    {   
    	$this->setOrderAttachments($attachments);
    }
    
    public function getEmAttachments()
    {
        return $this->getOrderAttachments(); 
    }
    
    public function setOrderAttachments($attachments)
    {   
    	$this->_filedata = $attachments;        
        return $this;
    }

    public function getOrderAttachments()
    {    	
        return $this->_filedata;
    }
    //end
    
}

