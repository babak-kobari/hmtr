<?php

require_once dirname ( __FILE__ ) . '/Rows/Rows.php';
class Users_Model_Travelprfncsgoodfor_Table extends Core_Db_Table_Abstract

{
	protected $_name = 'hm_user_trvlprfns_goof_for';
	protected $_primary = 'trvint_id';
	protected $_rowClass = 'Users_Model_Travelprfncsgoodfor_Row';
	
	public function getuserinterestgoodforbyuserId($user_id)
	{
	
	    $select = $this->select ();
	    $select->from ( array('a'=>'hm_param_good_for'));
	    $select->setIntegrityCheck(false);
	    $select->joinLeft(array('b'=>'hm_user_trvlprfns_goof_for'),
	                "b.trvint_param_id = a.param_id  and b.trvint_user_id =  $user_id ");
	
	    $rows = $this->fetchAll ( $select );
	    $rows=$rows->toArray();
	    $i=0;
	    foreach ($rows as $row)
	    {
	        if (is_null($rows[$i]['trvint_param_id']))
	        {
	            $rows[$i]['trvint_param_id']=$rows[$i]['param_id'];
	        }
	        if (is_null($row['trvint_user_id'])) $rows[$i]['trvint_user_id']=$user_id;
	        $i++;
	    }
	    return $rows;
	}
	

}