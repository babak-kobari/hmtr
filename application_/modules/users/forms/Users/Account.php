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
class Users_Form_Users_Account extends Users_Form_Users_Base
{
    protected $_row;
    
    public function init()
    {
        parent::init();
        $this->setName('userPersonalForm')->setMethod('post');
        
        $this->removeElement('firstname');
        $this->removeElement('lastname');
        $this->removeElement('gender');
        $this->removeElement('birth_date');
        $this->removeElement('nationality');
        $this->removeElement('currentlocation');
        $this->removeElement('about_me');
        $this->removeElement('travel_type');
        $this->removeElement('travel_style');
        
        
        return $this;
    }        
    

}
