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
	     $table=new Users_Model_Param_Table();
	     $select = $this->select();
	     $select->where('poifcl_param_category_id = ?',$group_id);
//	     $select->setIntegrityCheck(false);
//         $select->join(array('a'=>'hm_param'), 'a.param_id = poifcl_param_id',
//                        array('a.param_category_desc'));
		$rowset= $this->findDependentRowset ( 'Poi_Model_poifacl_Table',null,$select );
		$rowset=$rowset->toArray();
		foreach ($rowset as $key=>$row)
		{
		    $dummy=$table->getparambyId($row['poifcl_param_id']);
		    $rowset[$key]['param_category_desc']=$dummy['param_category_desc'];
		}
		return $rowset;
	}
	public function getImages() {
	    return $this->findDependentRowset ( 'Poi_Model_poiimages_Table' );
	}
	
}