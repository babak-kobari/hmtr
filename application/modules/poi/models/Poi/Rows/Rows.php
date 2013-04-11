<?php
class Poi_Model_Poi_Row extends Core_Db_Table_Row_Abstract
 {
    
	public function getStay_type() {
		return $this->findParentRow ( 'Users_Model_Param_Table', 'stay_type' )->param_category_desc;
	}
	public function getStay_class() {
		return $this->findParentRow ( 'Users_Model_Param_Table', 'stay_class' )->param_category_desc;
	}
	public function getLocation_type() {
		return $this->findParentRow ( 'Users_Model_Param_Table', 'location_type' )->param_category_desc;
	}
	public function getImages() {
	    return $this->findDependentRowset ( 'Poi_Model_Poiimages_Table' );
	}
	
}