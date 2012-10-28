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
class Poi_Form_Poi_amenities extends Poi_Form_Poi_Base
{
    protected $_row;
    
    public function init()
    {
        parent::init();
        $poi_id = $this->getAttrib('poi_id');
        $this->setAction('/poi/amenities/'.$poi_id);
        
        $this->removeElement('poi_name');
        $this->removeElement('poi_group_name');
        $this->removeElement('poi_web_site');
        $this->removeElement('poi_contact_detail');
        $this->removeElement('poi_stay_type');
        $this->removeElement('poi_stay_calssification');
        $this->removeElement('poi_country');
        $this->removeElement('poi_city');
        $this->removeElement('poi_area');
        $this->removeElement('poi_lat');
        $this->removeElement('poi_lon');
        $this->removeElement('poi_latlon');
        $this->removeElement('poi_location_type');
        $this->removeElement('poi_images');
        $this->getElement('submit')->setValue('poi/amenities/'.$poi_id);
        
        return $this;
    }        
    
}
