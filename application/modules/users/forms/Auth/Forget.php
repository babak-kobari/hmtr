<?php
/**
 * Forget password form
 *
 * @category Application
 * @package Model
 * @subpackage Form
 */
class Users_Form_Auth_Forget extends Core_Form
{
    /**
     * Form initialization
     *
     * @return void
     */
    public function init()
    {
        $this->addElementPrefixPath(
            'Users_Form_Auth_Validate',
            dirname(__FILE__) . "/Validate",
            'validate'
        );

        $this->setName('userForgetPasswordForm');

        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Enter your email')
              ->addDecorators($this->_inputDecorators)
              ->setRequired(true)
              ->setValue(null)
              ->addValidator('StringLength', false, array(6))
              ->addValidator('EmailAddress')
              ->addValidator(
                  'Db_RecordExists',
                  false,
                  array(
                      array('table' => 'hm_users', 'field' => 'email')
                  )
              );
        $email ->removeDecorator('Label');
        $email ->class='input-text required-entry';
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Restore');
        $submit->setAttrib('class', 'button');

        $this->addElements(array($email, $submit));

        return $this;
    }
}