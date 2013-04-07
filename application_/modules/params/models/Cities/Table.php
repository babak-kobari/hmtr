<?php 
class Params_Model_Cities_Table extends Core_Db_Table_Abstract
{

    
    protected $_name = 'hm_param_cities';
	
    protected $_primary = 'param_id';


	public function getcityId($param_id) {
		return $this->find ( $param_id )->current ();
	}
	public function getcityList($searchstring,$code) {
		$select = $this->select ();
		$select->where ( "param_desc LIKE '%".$searchstring."%'");
		$select->where ( 'cont_code = ? ',$code);
		
		return 	$this->fetchAll ( $select );
	}
	
}
