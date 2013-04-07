<?php
/**
 * Register user form
 *
 * @category Application
 * @package Model
 * @subpackage Form
 *
 * @todo Refactoring with DB validators
 * http://framework.zend.com/manual/en/zend.validate.set.html
 * #zend.validate.db.excluding-records
 */
class Users_Form_Users_Personal extends Users_Form_Users_Base
{
    protected $_row;
    
    public function init()
    {
        parent::init();
        $this->removeElement('login');
        $this->removeElement('email');
        return $this;
    }        
    
}
