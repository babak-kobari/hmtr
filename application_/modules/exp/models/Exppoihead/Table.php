<?php

/**
 * poifacl
 *  
 * @author Babak
 * @version 
 */
require_once dirname ( __FILE__ ) . '/Rows/Rows.php';
class Exp_Model_Exppoihead_Table extends Core_Db_Table_Abstract

{
	protected $_name = 'hm_exp_poi_head';
	protected $_primary = 'exp_poi_head_id';
	protected $_rowClass = 'Exp_Model_Exppoihead_Row';
	protected $_referenceMap = array (
	        'exp_head' => array (
	                'columns' => 'exp_id',
	                'refTableClass' => 'Exp_Model_Exp_Table',
	                'refColumns' => 'exp_id'),
	        'poi' => array (
	                'columns' => 'exp_poi_id' ,
	                'refTableClass' => 'Poi_Model_Poi_Table',
	                'refColumns' => 'poi_id'),
	        'user' => array (
	                'columns' => 'exp_poi_user_id',
	                'refTableClass' => 'Users_Model_User_Table',
	                'refColumns' => 'id')
	);
	protected $_dependentTables = array (
	        'Exp_Model_Exppoidetail_Table');
	
	
	public function getpoiexpbyId($exp_id,$poi_id)
	{
	    $select = $this->select ()->where ( 'exp_id = ?',$exp_id )
	                              ->where('exp_poi_id= ?', $poi_id);
	    $row=$this->fetchRow($select);
	    return $row;
	}
	
	
}
