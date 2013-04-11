<?php
class Exp_Model_Exp_Row extends Core_Db_Table_Row_Abstract
 {
    
	public function getTravel_with() {
		return $this->findParentRow ( 'Params_Model_Travelwith_Table', 'travel_with' )->param_desc;
	}
	public function getTravel_objective() {
		return $this->findParentRow ( 'Params_Model_Travelobjective_Table', 'travel_objective' )->param_desc;
	}
}