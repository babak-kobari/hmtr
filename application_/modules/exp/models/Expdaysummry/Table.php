<?php

/**
 * poifacl
 *  
 * @author Babak
 * @version 
 */
require_once dirname ( __FILE__ ) . '/Rows/Rows.php';
class Exp_Model_Expdaysummry_Table extends Core_Db_Table_Abstract

{
	protected $_name = 'hm_exp_day_smmry';
	protected $_primary = 'exp_day_summry_id';
	protected $_rowClass = 'Exp_Model_Expdaysummry_Row';
	protected $_referenceMap = array (
	        'exp_head' => array (
	                'columns' => 'exp_id',
	                'refTableClass' => 'Exp_Model_Exp_Table',
	                'refColumns' => 'exp_id')	);
	
	
	public function getexpdaysummaryIdandDayNo($exp_id,$exp_day_no)
	{
	    $select = $this->select ()->where ( 'exp_id = ?',$exp_id )
	                              ->where('exp_day_no = ?', $exp_day_no);
	    $row=$this->fetchRow($select);
	    if (isset($row))
	        $row=$row->toArray();
	    return $row;
	}
	
	
}
