<?php
class Poi_Form_Poi_Things extends Core_Form

{
	public function init() 
	{

	    $this->setName('PoithingsForm')->setMethod('post');
	    $param_desc_id = $this->getAttrib('param_desc_id');
	     
	     
	    $this->addElement($this->_poi_things_options($param_desc_id ));
	    $this->addElement($this->_poi_things_activity($param_desc_id ));
	    $this->addElement($this->_submit());
	     
	    return $this;
	}

	protected function _poi_things_options($param_desc_id )
	{
	    $element= new Zend_Form_Element_MultiCheckbox ( 'poi_things_options' );
		$this->_addoptions ( $element, 'Things', $param_desc_id );
	    return $element;
	}
	
	protected function _poi_things_activity($param_desc_id )
	{
	    $element= new Zend_Form_Element_MultiCheckbox ( 'poi_things_activity' );
	    $this->_addoptions ( $element, 'Things', $param_desc_id.'__Act' );
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
	        foreach ($datas as $data)
	        {
	            $temps=$data_model->getParamList($param_type, $data->param_category_desc);
	            foreach ($temps as $temp)
	            {
	            $result[$data->param_category_desc][$temp->param_id]=$temp->param_category_desc;
	                
	            }
	        }
	        $element->setMultiOptions($result);
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