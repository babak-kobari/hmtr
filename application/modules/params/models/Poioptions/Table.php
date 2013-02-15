<?php 
class Params_Model_Poioptions_Table extends Core_Db_Table_Abstract
{

    
    protected $_name = 'hm_param_poi_options';
	
    protected $_primary = 'param_id';


	public function getparambyId($param_id) {
		return $this->find ( $param_id )->current ();
	}
	public function getparamListbyType($option_type) {
		$select = $this->select ();
		$select->where('param_published = ?','P')
		       ->where('poi_option_type = ?', $option_type);
		return 	$this->fetchAll ( $select );
	}
	
}
