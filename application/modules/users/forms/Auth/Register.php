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
class Users_Form_Auth_Register extends Core_Form
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

        $this->setName('userRegisterForm');

        $username = new Zend_Form_Element_Text('login');
        $username->setLabel('User name')
                 ->addDecorators($this->_inputDecorators)
                 ->setRequired(true)
                 ->addFilter('StripTags')
                 ->addFilter('StringTrim')
                 ->addValidator('Alnum')
                 ->addValidator(
                     'StringLength', false,
                     array(Users_Model_User::MIN_USERNAME_LENGTH,
                           Users_Model_User::MAX_USERNAME_LENGTH)
                 )
                 ->addValidator(
                     'Db_NoRecordExists', false,
                     array(
                         array('table' => 'hm_users',
                               'field' => 'login')
                     )
                 );
        $username->removeDecorator('Label');
        $username->class='input-text required-entry';

        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Password')
                 ->addDecorators($this->_inputDecorators)
                 ->setRequired(true)
                 ->setValue(null)
                 ->addValidator(
                     'StringLength', false,
                     array(Users_Model_User::MIN_PASSWORD_LENGTH)
                 )
                 ->addValidator('PasswordConfirmation');

        $password ->removeDecorator('Label');
        $password ->class='input-text required-entry';
        

        $confirmPassword = new Zend_Form_Element_Password('password2');
        $confirmPassword->setLabel('Password again')
                  ->addDecorators($this->_inputDecorators)
                  ->setRequired(true)
                  ->setValue(null)
                  ->addValidator(
                      'StringLength', false,
                      array(Users_Model_User::MIN_PASSWORD_LENGTH)
                  );
        $confirmPassword ->removeDecorator('Label');
        $confirmPassword ->class='input-text required-entry';
        
        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email')
              ->addDecorators($this->_inputDecorators)
              ->setRequired(true)
              ->setValue(null)
              ->addValidator('StringLength', false, array(6))
              ->addValidator('EmailAddress')
              ->addValidator(
                  'Db_NoRecordExists', false,
                  array(
                      array('table' => 'hm_users', 'field' => 'email')
                  )
              );
        $email->removeDecorator('Label');
        $email->class='input-text required-entry';
        
        $imgDir = dirname(APPLICATION_PATH) . "/public/captcha";

        // check captcha path is writeable
        if (is_writable($imgDir)) {
            $captcha = new Zend_Form_Element_Captcha(
                'captcha',
                array(
                    'label' => "Please verify you're a human",
                    'captcha' => 'Image',
                    'captchaOptions' => array(
                        'captcha' => 'Image',
                        'wordLen' => 6,
                        'timeout' => 300,
                        'imgDir' => $imgDir,
                        'imgUrl' => '/captcha/',
                        'font' => dirname(APPLICATION_PATH) .
                                  "/data/fonts/Aksent_Normal.ttf",
                    ),
                )
            );
        } else {
            $captcha = new Zend_Form_Element_Captcha(
                'captcha',
                array(
                    'label' => "Please verify you're a human",
                    'captcha' => 'Figlet',
                    'captchaOptions' => array(
                        'wordLen' => 6,
                        'timeout' => 300,
                    ),
                )
            );
        }

        $captcha->addDecorators($this->_inputDecorators);
        $captcha->removeDecorator('Label');
        $captcha->class='input-text required-entry';
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Register');
        $submit->setAttrib('class', 'button');

        $this->addElements(
            array(
                $username,
                $password,
                $confirmPassword,
                $email,
                $captcha,
                $submit
            )
        );

        return $this;
    }
}