<?php
class Exp_Model_Exp_Row extends Core_Db_Table_Row_Abstract
 {
    
	public function getTravel_type() {
		return $this->findParentRow ( 'Users_Model_Param_Table', 'travel_type' )->param_category_desc;
	}
	public function getTravel_objective() {
		return $this->findParentRow ( 'Users_Model_Param_Table', 'travel_objective' )->param_category_desc;
	}
/*	public function getFacl($group_id)
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
	*/
}