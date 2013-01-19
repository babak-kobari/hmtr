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
					'columns' => 'exp_id',
					'refTableClass' => 'Exp_Model_Exp_Table',
					'refColumns' => 'exp_id' ) 
	        );
	
	public function getexpdaybyId($exp_days_id) {
		return $this->find ( $exp_days_id )->current ();
	}

	public function getexpdaysbyparent($exp_id)
	{
	     
	    $select = $this->select ()->setIntegrityCheck(false)
	                              ->from($this)
	                              ->join('hm_poi', 'hm_poi.poi_id=hm_exp_days.exp_poi_id',
	                                      array('poi_name','poi_lat','poi_lon','poi_type'))
	                              ->where ( 'hm_exp_days.exp_id= ?', $exp_id)
	                              ->order(array('exp_day_no','exp_poi_order'));
	    return $this->fetchAll ($select)->toArray(); 
	}
	
	public function getexpdaysbyprimary($exp_info)
	{
	    $select = $this->select ()->where ( 'exp_id = ?', $exp_info['exp_id'])
	                              ->where ( 'exp_day_no = ?' , $exp_info['exp_day_no'])
	                              ->where ( 'exp_poi_id = ?' , $exp_info['exp_poi_id']);
	                               
	    return $this->fetchRow($select);
	}
	
	
	
	
}
