<?php
class Exp_Form_Exp_Intro extends Core_Form

{
	public function init() 
	{

	    $this->setName('ExpBaseForm')->setMethod('post');
	    $exp_user_id = $this->getAttrib('exp_user_id');
	     
	     
	    $this->addElementPrefixPath(
	            'Exp_Form_Exp_Validate',
	            dirname(__FILE__) . "/Validate",
	            'validate');
	     
	    $this->addElement($this->_exptitle());
	    $this->addElement($this->_expadults());
	    $this->addElement($this->_expchilds());
	    $this->addElement($this->_expcity());
	    $this->addElement($this->_expcountry());
	    $this->addElement($this->_expdays());
	    $this->addElement($this->_expmount());
	    $this->addElement($this->_expoverallrate());
	    $this->addElement($this->_exptravel_objective());
	    $this->addElement($this->_exptravel_type());
	     
	    $this->addElement($this->_submit());
	    foreach($this->getElements() as $element)
	    {
	    
	        $element->removeDecorator('Label');
	    }
	     
	    return $this;
	}

	
	
	protected function _exptitle()
	{
	
		$element = new Zend_Form_Element_Text ( 'exp_title' );
//		$element->setLabel ( 'Name' )->setRequired ( 'true' );
		$element->maxlength = '200';
		// $poi_name->addValidator('Alnum');
		$element->class='input-text required-entry';
		return $element;
	}

	protected function _expcountry()
	{
	    $element= new Zend_Form_Element_Select ( 'exp_country' );
	    $element->class = 'field select medium';
	    $this->_addoptions ( $element, 'Gen', 'Country');
	    return $element;
	}
	protected function _expcity()
	{
	    $element= new Zend_Form_Element_Text ( 'exp_city' );
	    //		$element->setLabel ( 'City' )->setRequired ( 'true' );
		$element->class='input-text required-entry';
	    return $element;
	}
	
	protected function _expdays()
	{
	    $element= new Zend_Form_Element_Text ( 'exp_days' );
	    //		$element->setLabel ( 'City' )->setRequired ( 'true' );
	    $element->class='input-text required-entry';
	    return $element;
	}
	
	protected function _expadults()
	{
	    $element= new Zend_Form_Element_Text ( 'exp_adults' );
	    //		$element->setLabel ( 'City' )->setRequired ( 'true' );
	    $element->class='input-text required-entry';
	    return $element;
	}
	protected function _expchilds()
	{
	    $element= new Zend_Form_Element_Text ( 'exp_childs' );
	    //		$element->setLabel ( 'City' )->setRequired ( 'true' );
	    $element->class='input-text required-entry';
	    return $element;
	}
	protected function _expoverallrate()
	{
	    $element= new Zend_Form_Element_Text ( 'exp_overall_rate' );
	    //		$element->setLabel ( 'City' )->setRequired ( 'true' );
	    $element->class='input-text required-entry';
	    return $element;
	}
	protected function _exptravel_type()
	{
	    $element= new Zend_Form_Element_Select ( 'exp_travel_with' );
	    $element->class = 'field select medium';
	    $this->_addoptions ( $element, 'Gen', 'Travel_With' );
	    return $element;
	}
	protected function _exptravel_objective()
	{
	    $element= new Zend_Form_Element_Select ( 'exp_travel_objective' );
	    $element->class = 'field select medium';
	    $this->_addoptions ( $element, 'Gen', 'travel_objective' );
	    return $element;
	}
	protected function _expmount()
	{
	    $element= new Zend_Form_Element_Select ( 'exp_mount' );
	    $element->class = 'field select medium';
	    $element->addMultiOptions(array('Jan'=>'Jan',
	            'Feb'=>'Feb',
	            'Mar'=>'Mar',
	            'Apr'=>'Apr',
	            'May'=>'May',
	            'Jun'=>'Jun',
	            'Jul'=>'Jul',
	            'Aug'=>'Aug',
                'Sep'=>'Sep',
	            'Oct'=>'Oct',
	            'Nov'=>'Nov',
	            'Dec'=>'Dec'));
	    return $element;
	}
	
	
    
    
    
	protected function _submit()
	{
        $element = new Zend_Form_Element_Submit('submit');
        $element->setLabel('Save');
	    return $element;
	}
	
	protected function _addoptions (Zend_Form_Element $element, $param_type,
	        $param_classification)
	{
	    $data_model = new Users_Model_Param_Table();
	    $datas = $data_model->getParamList($param_type, $param_classification);
	    if ($param_classification=='TDO_Type')
	    {
	        $result=array();
	        $breaker = false;
	        foreach ($datas as $data)
	        {
	            $temps=$data_model->getParamList($param_type, $data->param_category_desc);
	            foreach ($temps as $temp)
	            {
	            $result[$data->param_category_desc][$temp->param_id]=$temp->param_category_desc;
	            if (!$breaker)
	            {
	                $default_value=$temp->param_category_desc;
	                $breaker=true;
	            }
	             
	            }
	        }
	        $element->setMultiOptions($result);
	        return $default_value;
	    }
	    else 
	    {
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
		
	
	public function _setfaclvalue(array $value = null,$name) {
	
		if (isset($value) and !is_null($value))
		{
    	    $element = $this->getElement ( $name );
	    	$element->setValue ( $value);
		}
	}
}