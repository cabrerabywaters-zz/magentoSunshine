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
/**
 *
 * @copyright  Copyright (c) 2011 AITOC, Inc.
 * @package    Aitoc_Aitemails
 * @author lyskovets
 */
abstract class Aitoc_Aitemails_Model_Observer_Abstract
    extends Varien_Object
{
    abstract public function process(Varien_Event_Observer $event);
}