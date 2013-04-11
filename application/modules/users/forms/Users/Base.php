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
class Users_Form_Users_Base extends Core_Form

{
    protected $_row;
    
    public function init()
    {
        
        $this->setName('userBaseForm')->setMethod('post');
        $user_id = $this->getAttrib('user_id');
        
        $this->addElementPrefixPath(
                'Users_Form_Users_Validate',
                dirname(__FILE__) . "/Validate",
                'validate');
        $country = $this->getcountrylist();
        $this->addElement($this->_username($user_id));
        $this->addElement($this->_firstname());
        $this->addElement($this->_lastname());
        $this->addElement($this->_gender());
//        $this->addElement($this->_status());
        $this->addElement($this->_email($user_id));
//        $this->addElement($this->_facebookid());
//        $this->addElement($this->_tweeterid());
//        $this->addElement($this->_googleid());
        $this->addElement($this->_birthdate());
        $this->addElement($this->_nationality($country));
        $this->addElement($this->_currentlocation($country));
        $this->addElement($this->_aboutme());
        $this->addElement($this->_travelstyle());
        
        $this->addElement($this->_submit());
        foreach($this->getElements() as $element)
            {

                $element->removeDecorator('Label');
            }        
        return $this;
        
    }        
    
    protected function _username($user_id)
    {
        $element = new Zend_Form_Element_Text('login');
        $element->addDecorators($this->_inputDecorators)
        ->setRequired(true)
        ->addFilter('StringTrim')
        ->addValidator('Alnum')
        ->addValidator(
                'StringLength',
                false,
                array(Users_Model_User::MIN_USERNAME_LENGTH,
                        Users_Model_User::MAX_USERNAME_LENGTH)
        );
        
        $options=array('table' => 'hm_users', 
                       'field' => 'login',
                        'exclude'   => array(
                                       'field' => 'id',
                                       'value' => $user_id));
                
        $db_lookup_validator = new Zend_Validate_Db_NoRecordExists($options);
        
        $element->class='input-text required-entry';
        $element->addValidator($db_lookup_validator);
        
        
        
        return $element;
    }
    
    protected function _birthdate()
    {
        $birth_date = new Zend_Form_Element_Text('birth_date');
        
        $validator = new Zend_Validate_Date();
        $birth_date->addValidator($validator);

        $birth_date->class='input-text';
        $birth_date->size = '10';
        $birth_date->maxlength = '10';
        return $birth_date;
    }
    
    protected function _nationality(&$country)
    {
        $nationality = new Zend_Form_Element_Select('nationality');
        $nationality ->setLabel('Nationality')->setRequired('false');
        foreach ($country as $data)
        {
            $nationality->addMultiOption($data->country_id,
                    $data->country_name);
        }
        return $nationality;
    }
    
    protected function _currentlocation(&$country)
    {
        $currentlocation  = new Zend_Form_Element_Select('currentlocation ');
        $currentlocation ->setLabel('Current Location ')->setRequired('false');
        foreach ($country as $data)
            {
               $currentlocation->addMultiOption($data->country_id,
               $data->country_name);
            }
        return $currentlocation ;
    }
    
    protected function _gender()
    {
        $gender = new Zend_Form_Element_Radio('gender');
        $gender->addMultiOptions(array(
                    '1' => 'Male',
                    '2' => 'Female' 
                        ))
            ->setSeparator('');       
        $gender->class = 'radio';
        return $gender;
    }
    protected function _aboutme()
    {
        $aboutme = new Zend_Form_Element_Textarea('about_me');
        $aboutme->setLabel('About Me')->setRequired('false');
        
        $filter = new Zend_Filter_StringTrim();
        $aboutme->addFilter($filter);
        
        $validator = new Zend_Validate_StringLength();
        $validator->setMax(2000);
        $aboutme->addValidator($validator);
        
        $aboutme->cols= 50;
        $aboutme->rows=10;
        $aboutme->maxlength = '2000';
        return $aboutme;
    }
    
    protected function _travelstyle()
    {
        $travel_style = new Zend_Form_Element_Select('travel_style');
        $travel_style->setLabel('Your Travel Style')->setRequired('false');
        $table = new Params_Model_Params_Manager();
        $rows=$table->getTravelStyleAll();
        foreach ($rows as $data)
            {
               $travel_style->addMultiOption($data->param_id,
               $data->param_desc);
            }
        
        return $travel_style;
    }
    
    protected function _firstname()
    {
        $element = new Zend_Form_Element_Text('firstname');
        $element->setLabel('First Name')
        ->addValidator(
            'StringLength',
            false,
            array('max' => Users_Model_User::MAX_FIRSTNAME_LENGTH)
     )
        ->addValidator('Alpha');

    $element->class='input-text required-entry';
        
    return $element;
    }

    
    protected function _lastname()
    {
        $element = new Zend_Form_Element_Text('lastname');
        $element->setLabel('Last Name')
        ->addValidator(
                'StringLength',
                false,
                array('max' => Users_Model_User::MAX_LASTNAME_LENGTH)
        )
        ->addValidator('Alpha');
        $element->class='input-text required-entry';
        
    
        return $element;
    }
    
    protected function _email($user_id)
    {
        $element = new Zend_Form_Element_Text('email');
        $element->setRequired(true)
        ->addValidator('EmailAddress');
        $options=array('table' => 'hm_users', 
                       'field' => 'email',
                        'exclude'   => array(
                                       'field' => 'id',
                                       'value' => $user_id));
                
        $db_lookup_validator = new Zend_Validate_Db_NoRecordExists($options);
        $element->class='input-text required-entry';
        $element->addValidator($db_lookup_validator);    
        return $element;
    }
    
    
    protected function _submit()
    {
        $element = parent::_submit();
        $element->setLabel('Update');
        $element->class = 'button';
    
        return $element;
    }
    
    protected function getcountrylist()
    {
        $table = new Params_Model_Params_Manager();
        return  $table->getcountryAll();
    }
    
    protected function _addoptions (Zend_Form_Element_Select $element, $param_type,
            $param_classification)
    {
        $data_model = new Params_Model_Params_Manager();
        $datas = $data_model->getParamList($param_type, $param_classification);
        foreach ($datas as $data) 
        {
            if ($data->param_published == 'P') {
                $element->addMultiOption($data->param_id,
                        $data->param_category_desc);
            }
            if ($data->param_action == 'D') {
                $element->setValue($data->param_id);
            }
        }
    }
    


}
