<?php 
class Params_Model_Goodfor_Table extends Core_Db_Table_Abstract
{

    
    protected $_name = 'hm_param_good_for';
	
    protected $_primary = 'param_id';


	public function getparambyId($param_id) {
		return $this->find ( country_id )->current ();
	}
	public function getparamList() {
		$select = $this->select ();
		$select->where('param_published = ?','P');
		return 	$this->fetchAll ( $select );
	}
	
}
