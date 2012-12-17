<?php

/**
 * poifacl
 *  
 * @author Babak
 * @version 
 */
require_once dirname ( __FILE__ ) . '/Rows/Rows.php';
class Exp_Model_expdays_Table extends Core_Db_Table_Abstract

{
	protected $_name = 'hm_exp_days';
	protected $_primary = 'exp_days_id';
	protected $_rowClass = 'Exp_Model_expdays_Row';
	protected $_referenceMap = array (
			'relatedPoi' => array (
					'columns' => 'exp_poi_id',
					'refTableClass' => 'Poi_Model_Poi_Table',
					'refColumns' => 'poi_id'),
			'facldesc' => array (
					'columns' => 'exp_head_id',
					'refTableClass' => 'Exp_Model_Exp_Table',
					'refColumns' => 'exp_id' ) 
	        );
	
	public function getexpdaybyId($exp_days_id) {
		return $this->find ( $exp_days_id )->current ();
	}

	public function getexpdaysbyparent($exp_head_id)
	{
	    $select = $this->select ()->where ( 'exp_head_id = ?', $exp_head_id)
	                              ->group('exp_day_no');
	    
	    return $this->fetchAll ($select); 
	}
	
	public function getexpdaysbyprimary($exp_info)
	{
	    $select = $this->select ()->where ( 'exp_head_id = ?', $exp_info['exp_head_id'])
	                              ->where ( 'exp_day_no = ?' , $exp_info['exp_day_no'])
	                              ->where ( 'exp_poi_id = ?' , $exp_info['exp_poi_id']);
	                               
	    return $this->fetchRow($select);
	}
	
	
	
	
}
