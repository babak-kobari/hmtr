<?php

require_once dirname ( __FILE__ ) . '/Rows/Rows.php';

class Exp_Model_Exp_Table extends Core_Db_Table_Abstract
{
	protected $_name = 'hm_exp_head';
	protected $_primary = 'exp_id';
	protected $_rowClass = 'Exp_Model_Exp_Row';
	protected $_referenceMap = array (
	'travel_type' => array (
	        'columns' => 'exp_travel_type',
	        'refTableClass' => 'Users_Model_Param_Table',
	        'refColumns' => 'param_id'),
	        'travel_objective' => array (
	                'columns' => 'exp_travel_objective' ,
	                'refTableClass' => 'Users_Model_Param_Table',
	                'refColumns' => 'param_id')
	                        );
	                protected $_dependentTables = array (
	                        'Exp_Model_expdays_Table');
	
	
	public function getExpbyId($exp_id) {
		$row = $this->find ( $exp_id )->current ();
		return $row;
	}
	
	public function getExpbyTitle($exp_title) {
		return $this->fetchRow ( $this->select ()->where ( 'exp_title like ?' ), $exp_title);
	}

	public function getExpbyUserId($exp_user_id) {
	    return $this->fetchAll ( $this->select ()->where ( 'exp_user_id = ?' ), $exp_user_id);
	}
	
	public function saveExphead($info)
	{
	    $exo_id = $this->saveRow( $info);
	    return $exo_id;
	   
	     
	}

}