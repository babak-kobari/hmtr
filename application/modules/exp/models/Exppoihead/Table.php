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
	
	
	public function getpoiexpbyexoIdandpoiId($exp_id,$poi_id)
	{
	    $select = $this->select ()->where ( 'exp_id = ?',$exp_id )
	                              ->where('exp_poi_id= ?', $poi_id);
	    $row=$this->fetchRow($select);
	    return $row;
	}

	public function getpoiheadbyexpId($exp_id)
	{
	    $select = $this->select ()->where ( 'exp_id = ?',$exp_id );
	    $row=$this->fetchAll($select);
	    return $row;
	}
	
	public function deletexppodetailbyexpId($exp_id)
	{
	    $exppoihead_rows= $this->getpoiheadbyexpId($exp_id);
	    $exppoidetail = new Exp_Model_Exppoidetail_Table();
	    if (isset($exppoihead_rows))
	    {
	        $exppoihead_rows=$exppoihead_rows->toArray();
	        foreach ($exppoihead_rows as $exppoihead_row)
	        {
	            $exppoidetail->deleteexppoidetailbyheadId($exppoihead_row['exp_poi_head_id']);
	        }
	    }
	    $this->delete('exp_id = '.$exp_id);
	}
	
	public function expchangestatusbyexpId($exp_id,$status)
	{
	    $exppoihead_rows= $this->getpoiheadbyexpId($exp_id);
	    $exppoidetail = new Exp_Model_Exppoidetail_Table();
	    if (isset($exppoihead_rows))
	    {
	        $exppoihead_rows=$exppoihead_rows->toArray();
	        foreach ($exppoihead_rows as $exppoihead_row)
	        {
	            $exppoidetail->expchangestatusbyexpId($exppoihead_row['exp_poi_head_id'], $status);
	        }
	    }
	    $data = array('exp_status'=> $status);
	    $where = 'exp_id = '.$exp_id;
	    $this->update($data,$where);
	}
	
}
