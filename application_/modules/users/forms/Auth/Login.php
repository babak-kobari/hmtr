<?php
/**
 * Login form
 *
 * @category Application
 * @package Model
 * @subpackage Form
 */
class Users_Form_Auth_Login extends Core_Form
{
    /**
     * Form initialization
     *
     * @return void
     */
    public function init()
    {
        $this->setName('userLoginForm');

        $username = new Zend_Form_Element_Text('login');
        $username->setLabel('User name')
                 ->addDecorators($this->_inputDecorators)
                 ->setRequired(true)
                 ->addFilter('StripTags')
                 ->addFilter('StringTrim');
        
        
        $username->removeDecorator('Label');
        $username->class='input-text required-entry';
        
        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Password')
                 ->addDecorators($this->_inputDecorators)
                 ->setRequired(true);
        $password ->removeDecorator('Label');
        $password ->class='input-text required-entry';
        
        $rememberMe = new Zend_Form_Element_Checkbox('rememberMe');
        $rememberMe->setLabel('Remember Me');
        $rememberMe->class='checkbox';
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Login');
        $submit->class='button';

        $this->addElements(array($username, $password, $rememberMe, $submit));

        return $this;
    }
}