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
class Poi_Form_Poi_Generalinfo extends Poi_Form_Poi_Base
{
    protected $_row;
    
    public function init()
    {
        parent::init();
            $poi_id = $this->getAttrib('poi_id');
    	    $poi_type = $this->getAttrib('poi_type');
    	    $param_desc_id = $this->getAttrib('param_desc_id');
    	    	
    	    if ($poi_type=='Stay')
    	    {
    	        $this->removeElement('poi_dining_options');
    	        $this->removeElement('Cuisine');
    	        $this->removeElement('poi_things_options');
    	        $this->removeElement('poi_things_activity');
    	         
    	    }
        	if ($poi_type=='Eat')
    	    {
    	        $this->removeElement('poi_amenities');
                $this->removeElement('poi_group_name');
                $this->removeElement('poi_stay_calssification');
                $this->removeElement('poi_location_type');
    	        $this->removeElement('poi_things_options');
    	        $this->removeElement('poi_things_activity');
    	    }
            if ($poi_type=='Things')
    	    {
    	        $this->removeElement('poi_dining_options');
    	        $this->removeElement('Cuisine');
    	        $this->removeElement('poi_amenities');
                $this->removeElement('poi_group_name');
                $this->removeElement('poi_stay_calssification');
                $this->removeElement('poi_location_type');
    	    }
    	    return $this;
    }        
    
}
