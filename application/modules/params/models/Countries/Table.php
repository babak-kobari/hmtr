<?php 
class Params_Model_Countries_Table extends Core_Db_Table_Abstract
{

    
    protected $_name = 'hm_param_country';
	
    protected $_primary = 'country_id';


	public function getcountryId($country_id) {
		return $this->find ( country_id )->current ();
	}
	public function getcountryList($searchstring) {
		$select = $this->select ();
		$select->where ( "country_name LIKE '%".$searchstring."%'");
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
