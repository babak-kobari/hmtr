<?php
class Poi_Form_Poi_RelatedPoi extends Core_Form

{
	public function init() 
	{

	    $this->setName('RelatedPoiForm')->setMethod('post');
	    $poi_id = $this->getAttrib('poi_id');
	    $poi_type = $this->getAttrib('poi_type');
	    $staylist = $this->getAttrib('stay_list');
	    $eatlist= $this->getAttrib('eat_list');
	    $thingslist = $this->getAttrib('things_list');
	    $relatedlist = $this->getAttrib('related_list');
	     
	    $this->addElementPrefixPath(
	            'Poi_Form_poi_Validate',
	            dirname(__FILE__) . "/Validate",
	            'validate');
	     
	    $this->addElement($this->_poistaylist($staylist));
	    $this->addElement($this->_poieatlist($eatlist));
	    $this->addElement($this->_poithingslist($thingslist));
	    $this->addElement($this->_poirelatedlist($relatedlist));
	    $this->addElement($this->_submit());
	    return $this;
	}

	
	protected function _poistaylist($staylist)
	{
	
		$element = new Zend_Form_Element_Select('Stay_list' );
		$element->rows=5;
		$this->_addoptions ( $element, $staylist);
		return $element;
	}
	
	protected function _poieatlist($eatlist)
	{
	
	    $element = new Zend_Form_Element_Select('Eat_list' );
	    $element->width=10;
	    $this->_addoptions ( $element, $eatlist);
	    return $element;
	}
	protected function _poithingslist($thingslist)
	{
	
	    $element = new Zend_Form_Element_Select('Things_list' );
	    $element->width=10;
	    $element->rows=5;
	    $this->_addoptions ( $element, $thingslist);
	    return $element;
	}
	
	protected function _poirelatedlist($relatedlist )
	{
	
	    $element = new Zend_Form_Element_Multiselect('Related_list' );
	    $element->rows=5;
	    $this->_addoptions ( $element, $relatedlist );
	    return $element;
	}
	
	protected function _submit()
	{
        $element = new Zend_Form_Element_Submit('submit');
        $element->setLabel('Save');
	    return $element;
	}
	
	protected function _addoptions (Zend_Form_Element $element, $options)
	{
	    foreach ($options as $option)
	    {
         $element->addMultiOption($option['poi_id'],$option['poi_name']);
	    }
	}
	
}