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
	public function getFacl($group_id)
	 {
	     $select = $this->select();
	     $select->where('poifcl_param_category_id = ?',$group_id);
//	            ->where('param_published = ?', 'P')
//	            ->where('param_action <> ?', 'D');
		return $this->findDependentRowset ( 'Poi_Model_poifacl_Table',null,$select );
	}
	public function getImages() {
	    return $this->findDependentRowset ( 'Poi_Model_poiimages_Table' );
	}
	
}