<?php
class Exp_Form_Exp_Daysummary extends Core_Form

{
	public function init() 
	{

	    $this->setName('ExpdaysumForm')->setMethod('post');
	     
	    $this->addElementPrefixPath(
	            'Exp_Form_Exp_Validate',
	            dirname(__FILE__) . "/Validate",
	            'validate');
	     
	    $this->addElement($this->_transp_type());
	    $this->addElement($this->_trans_cost());
	    $this->addElement($this->_total_cost());
	    $this->addElement($this->_transcomment());
	    foreach($this->getElements() as $element)
	    {
	    
	        $element->removeDecorator('Label');
	    }
	     
	    return $this;
	}

	
	
	protected function _trans_cost()
	{
	
		$element = new Zend_Form_Element_Text ( 'exp_trans_cost' );
		$element->maxlength = '200';
		$element->class='input-text required-entry';
		return $element;
	}

	protected function _total_cost()
	{
	
		$element = new Zend_Form_Element_Text ( 'exp_day_cost' );
		$element->maxlength = '200';
		$element->class='input-text required-entry';
		return $element;
	}
	
	protected function _transp_type()
	{
	    $element= new Zend_Form_Element_Select ( 'exp_trans_type' );
	    $element->class = 'field select medium';
	    $element->addMultiOption('1','Taxi');
	    $element->addMultiOption('2','Public Transport');
	    $element->addMultiOption('3','Tour (as defined in the day detail)');
	    return $element;
	}
	
	protected function _transcomment()
	{
	    $element= new Zend_Form_Element_Textarea('exp_trans_comment');
	    $element->setLabel('About Me')->setRequired('false');
	
	    $filter = new Zend_Filter_StringTrim();
	    $element->addFilter($filter);
	
	    $validator = new Zend_Validate_StringLength();
	    $validator->setMax(2000);
	    $element->addValidator($validator);
	
	    $element->cols= 50;
	    $element->rows=2;
	    $element->maxlength = '2000';
	    return $element;
	}
	
    
    
    
}