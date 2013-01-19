<?php
class Exp_Form_Exp_Exppoi extends Core_Form

{
	public function init() 
	{

	    $this->setName('ExppoiForm')->setMethod('post');
	    $poi_id = $this->getAttrib('poi_id');
	    $poi_type = $this->getAttrib('poi_type');
	    $param_desc_id = $this->getAttrib('param_desc_id');
	    $param_default_id = 0;
	     
	     
	    $this->addElementPrefixPath(
	            'Poi_Form_poi_Validate',
	            dirname(__FILE__) . "/Validate",
	            'validate');
	     
	    $this->addElement($this->_exppoiavgcost());
	    $this->addElement($this->_exppoicondition());
	    $this->addElement($this->_exppoidesc());
	    $this->addElement($this->_exppoidish1());
	    $this->addElement($this->_exppoidish1rate());
	    $this->addElement($this->_exppoidish2());
	    $this->addElement($this->_exppoidish2rate());
	    $this->addElement($this->_exppoidish3());
	    $this->addElement($this->_exppoidish3rate());
	    $this->addElement($this->_exppoirating());
	    $this->addElement($this->_exppoiroomrating());
	    $this->addElement($this->_exppoiroomtype());
	    $this->addElement($this->_exppoiroomview());
	    $this->addElement($this->_exppoitime());
	    $this->addElement($this->_exppoititle());
	    $this->addElement($this->_submit());
	    foreach($this->getElements() as $element)
	    {
	    
	        $element->removeDecorator('Label');
	    }
	     
	    return $this;
	}


	
	protected function _exppoititle()
	{
	
	    $element = new Zend_Form_Element_Text ( 'exp_poi_title' );
	    //		$element->setLabel ( 'Name' )->setRequired ( 'true' );
	    $element->size = '35';
	    $element->maxlength = '200';
	    // $poi_name->addValidator('Alnum');
	    $element->class='input-text required-entry';
	    return $element;
	}

	protected function _exppoiid($poi_id)
	{
	
	    $element = new Zend_Form_Element_Hidden( 'exp_poi_id' );
	    $element->setValue($poi_id);
	    return $element;
	}
	
	
	protected function _exppoiavgcost()
	{
	
	    $element = new Zend_Form_Element_Text ( 'exp_poi_average_cost' );
	    //		$element->setLabel ( 'Name' )->setRequired ( 'true' );
	    $element->size = '35';
	    $element->maxlength = '200';
	    $element->setValue(0);
	    // $poi_name->addValidator('Alnum');
	    $element->class='input-text required-entry';
	    return $element;
	}
	
	protected function _exppoiroomtype()
	{
	
	    $element = new Zend_Form_Element_Text ( 'exp_stay_room_type' );
	    //		$element->setLabel ( 'Name' )->setRequired ( 'true' );
	    $element->size = '35';
	    $element->maxlength = '200';
	    // $poi_name->addValidator('Alnum');
	    $element->class='input-text required-entry';
	    return $element;
	}
	
	protected function _exppoiroomview()
	{
	
	    $element = new Zend_Form_Element_Text ( 'exp_stay_room_view' );
	    //		$element->setLabel ( 'Name' )->setRequired ( 'true' );
	    $element->size = '35';
	    $element->maxlength = '200';
	    // $poi_name->addValidator('Alnum');
	    $element->class='input-text required-entry';
	    return $element;
	}
	
	protected function _exppoidesc()
	{
	
	    $element = new Zend_Form_Element_Text ( 'exp_poi_short_description' );
	    //		$element->setLabel ( 'Name' )->setRequired ( 'true' );
	    $element->size = '35';
	    $element->maxlength = '200';
	    // $poi_name->addValidator('Alnum');
	    $element->class='input-text required-entry';
	    return $element;
	}
	
	protected function _exppoirating()
	{
	
	    $element = new Zend_Form_Element_Text ( 'exp_poi_overal_rating' );
	    //		$element->setLabel ( 'Name' )->setRequired ( 'true' );
	    $element->size = '35';
	    $element->maxlength = '200';
	    $element->setValue(0);
	    // $poi_name->addValidator('Alnum');
	    $element->class='input-text required-entry';
	    return $element;
	}

	protected function _exppoidish1rate()
	{
	
	    $element = new Zend_Form_Element_Text ( 'exp_eat_your_dish1_rate' );
	    $element->size = '35';
	    $element->maxlength = '200';
	    $element->setValue(0);
	    // $poi_name->addValidator('Alnum');
	    $element->class='input-text required-entry';
	    return $element;
	}
	
	protected function _exppoidish2rate()
	{
	
	    $element = new Zend_Form_Element_Text ( 'exp_eat_your_dish2_rate' );
	    $element->size = '35';
	    $element->maxlength = '200';
	    $element->setValue(0);
	    // $poi_name->addValidator('Alnum');
	    $element->class='input-text required-entry';
	    return $element;
	}
	protected function _exppoidish3rate()
	{
	
	    $element = new Zend_Form_Element_Text ( 'exp_eat_your_dish3_rate' );
	    $element->size = '35';
	    $element->maxlength = '200';
	    $element->setValue(0);
	    // $poi_name->addValidator('Alnum');
	    $element->class='input-text required-entry';
	    return $element;
	}
	
	protected function _exppoiroomrating()
	{
	
	    $element = new Zend_Form_Element_Text ( 'exp_stay_room_rating' );
	    //		$element->setLabel ( 'Name' )->setRequired ( 'true' );
	    $element->setValue(0);
	    $element->size = '35';
	    $element->maxlength = '200';
	    // $poi_name->addValidator('Alnum');
	    $element->class='input-text required-entry';
	    return $element;
	}
	protected function _exppoitime()
	{
	
	    $element = new Zend_Form_Element_Radio('exp_poi_average_time');
	    $element->setLabel('Halal:');
	    $element->addMultiOptions(array(
	            '1' => 'Less than 2 Hours',
	            '2' => 'Around 2 Hours',
	            '3' => 'Half Day',
	            '4' => 'Full Day'
	    ))
	    ->setSeparator('');
	    $element->class='radio';
	    return $element;
	 }
	 protected function _exppoidish1()
	 {
	 
	     $element = new Zend_Form_Element_Text ( 'exp_eat_your_dish1' );
	     //		$element->setLabel ( 'Name' )->setRequired ( 'true' );
	     $element->size = '35';
	     $element->maxlength = '200';
	     // $poi_name->addValidator('Alnum');
	     $element->class='input-text required-entry';
	     return $element;
	 }
	 protected function _exppoidish2()
	 {
	 
	     $element = new Zend_Form_Element_Text ( 'exp_eat_your_dish2' );
	     //		$element->setLabel ( 'Name' )->setRequired ( 'true' );
	     $element->size = '35';
	     $element->maxlength = '200';
	     // $poi_name->addValidator('Alnum');
	     $element->class='input-text required-entry';
	     return $element;
	 }
	 protected function _exppoidish3()
	 {
	 
	     $element = new Zend_Form_Element_Text ( 'exp_eat_your_dish3' );
	     //		$element->setLabel ( 'Name' )->setRequired ( 'true' );
	     $element->size = '35';
	     $element->maxlength = '200';
	     // $poi_name->addValidator('Alnum');
	     $element->class='input-text required-entry';
	     return $element;
	 }
	 protected function _exppoicondition()
	 {
	 
	     $element = new Zend_Form_Element_Text ( 'exp_poi_special_condition' );
	     //		$element->setLabel ( 'Name' )->setRequired ( 'true' );
	     $element->size = '35';
	     $element->maxlength = '200';
	     // $poi_name->addValidator('Alnum');
	     $element->class='input-text required-entry';
	     return $element;
	 }
	 
	
	
    
    
	protected function _submit()
	{
        $element = new Zend_Form_Element_Submit('submit');
        $element->setLabel('Save');
	    return $element;
	}
	
}