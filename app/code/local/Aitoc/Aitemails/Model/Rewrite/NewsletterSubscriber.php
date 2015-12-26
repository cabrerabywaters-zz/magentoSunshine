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
/* AITOC static rewrite inserts start */
/* $meta=%default,AdjustWare_Notification% */
if(Mage::helper('core')->isModuleEnabled('AdjustWare_Notification')){
    class Aitoc_Aitemails_Model_Rewrite_NewsletterSubscriber_Aittmp extends AdjustWare_Notification_Model_Rewrite_Newsletter_Subscriber {} 
 }else{
    /* default extends start */
    class Aitoc_Aitemails_Model_Rewrite_NewsletterSubscriber_Aittmp extends Mage_Newsletter_Model_Subscriber {}
    /* default extends end */
}

/* AITOC static rewrite inserts end */
class Aitoc_Aitemails_Model_Rewrite_NewsletterSubscriber extends Aitoc_Aitemails_Model_Rewrite_NewsletterSubscriber_Aittmp
{
    public function sendConfirmationSuccessEmail()
    {
        if ($this->getImportMode()) {
            return $this;
        }

        if(!Mage::getStoreConfig(self::XML_PATH_SUCCESS_EMAIL_TEMPLATE)
            || !Mage::getStoreConfig(self::XML_PATH_SUCCESS_EMAIL_IDENTITY)
        ) {
            return $this;
        }

        $translate = Mage::getSingleton('core/translate');
        /* @var $translate Mage_Core_Model_Translate */
        $translate->setTranslateInline(false);

        $email = Mage::getModel('core/email_template');

        $email->sendTransactional(
            Mage::getStoreConfig(self::XML_PATH_SUCCESS_EMAIL_TEMPLATE, $this->getStoreId()),
            Mage::getStoreConfig(self::XML_PATH_SUCCESS_EMAIL_IDENTITY, $this->getStoreId()),
            $this->getEmail(),
            $this->getName(),
            array('subscriber'=>$this)
        );

        $translate->setTranslateInline(true);

        return $this;
    }

    public function sendUnsubscriptionEmail()
    {
        if ($this->getImportMode()) {
            return $this;
        }
        if(!Mage::getStoreConfig(self::XML_PATH_UNSUBSCRIBE_EMAIL_TEMPLATE)
            || !Mage::getStoreConfig(self::XML_PATH_UNSUBSCRIBE_EMAIL_IDENTITY)
        ) {
            return $this;
        }

        $translate = Mage::getSingleton('core/translate');
        /* @var $translate Mage_Core_Model_Translate */
        $translate->setTranslateInline(false);

        $email = Mage::getModel('core/email_template');

        $email->sendTransactional(
            Mage::getStoreConfig(self::XML_PATH_UNSUBSCRIBE_EMAIL_TEMPLATE, $this->getStoreId()),
            Mage::getStoreConfig(self::XML_PATH_UNSUBSCRIBE_EMAIL_IDENTITY, $this->getStoreId()),
            $this->getEmail(),
            $this->getName(),
            array('subscriber'=>$this)
        );

        $translate->setTranslateInline(true);

        return $this;
    }
}