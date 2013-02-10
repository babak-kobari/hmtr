<?php 
class Params_Model_Countries_Table extends Core_Db_Table_Abstract
{

    
    protected $_name = 'hm_param_country';
	
    protected $_primary = 'param_id';


	public function getcountryId($param_id) {
		return $this->find ( $param_id )->current ();
	}
	public function getcountryList($searchstring) {
		$select = $this->select ();
		$select->where ( "param_desc LIKE '%".$searchstring."%'");
		return 	$this->fetchAll ( $select );
	}
	public function getcountrybyCode($code) {
	    $select = $this->select ();
	    $select->where ( 'country_code = ?',$code);
	    return 	$this->fetchAll ( $select );
	}
	public function getcountryAll() {
	    return 	$this->fetchAll ();
	}
	
	
}
