<?php

/**
 * poifacl
 *  
 * @author Babak
 * @version 
 */
require_once dirname ( __FILE__ ) . '/Rows/Rows.php';
class Exp_Model_Exppoidetail_Table extends Core_Db_Table_Abstract

{
	protected $_name = 'hm_exp_poi_detail';
	protected $_primary = 'exp_poi_detail_id';
	protected $_rowClass = 'Exp_Model_Exppoidetail_Row';
	protected $_referenceMap = array (
	        'exp_poi_head' => array (
	                'columns' => 'exp_poi_head_id',
	                'refTableClass' => 'Exp_Model_Exppoihead_Table',
	                'refColumns' => 'exp_poi_head_id'),
			'exp_poi_facldesc' => array (
					'columns' => 'exp_poi_param_id',
					'refTableClass' => 'Users_Model_User_Table',
					'refColumns' => 'param_id' ) 
	);
	
	
	public function getpoiexpdetailbyId($head_id,$param_id)
	{
	    $select = $this->select ()->where ( 'exp_poi_head_id = ?',$head_id )
	    ->where('exp_poi_param_id= ?', $param_id);
	    $row=$this->fetchRow($select);
	    return $row;
	}
	
	public function deleteexppoidetailbyheadId($exp_poi_head_id)
	{
	    $this->delete('exp_poi_head_id = '.$exp_poi_head_id);
	}
	
	public function expchangestatusbyexpId($exp_poi_head_id,$status)
	{
	    $data = array('exp_status'=> $status);
	    $where = 'exp_poi_head_id = '.$exp_poi_head_id;
	    $this->update($data,$where);
	}
	
	
}
