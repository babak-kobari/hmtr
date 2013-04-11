<?php 
require_once dirname ( __FILE__ ) . '/Rows/Rows.php';
class sers_Model_Param_Table extends Core_Db_Table_Abstract
{

    
    protected $_name = 'hm_param';
	
    protected $_primary = 'param_id';

    protected $_rowClass = 'Users_Model_Param_Row';
    protected $_dependentTables = array (
            'Poi_Model_poifacl_Table',
            'Poi_Model_Poi_Table');

	public function getparambyId($param_id) {
		return $this->find ( $param_id )->current ();
	}
	public function getParamList($Param_Type, $Param_Category_id = null) {
		$select = $this->select ();
		$select->from ( 'hm_param' )->where ( "param_type = ?", $Param_Type )
		                    ->where ( "param_category_id = ?", $Param_Category_id )
		                    ->where('param_published = ?', 'P');
		return 	$this->fetchAll ( $select );
	}
	public function getusertavelinterestbyuserId($user_id,$cat = null)
	{
	
	    $select = $this->select ();
	    if ($cat == null)
	    {
	        $select->from ( array('a'=>'hm_param'));
	        $select->setIntegrityCheck(false);
	        $select->joinleft(array('b'=>'hm_user_travelpreferences'),
	                "b.trvint_param_id = a.param_id" and "b.trvint_user_id= ?",$user_id);
	    }
	    else
	    {
	        $select->from ( array('a'=>'hm_param'));
	        $select->setIntegrityCheck(false);
	        $select->joinLeft(array('b'=>'hm_user_travelpreferences'),
	                "b.trvint_param_id = a.param_id  and b.trvint_user_id =  $user_id ");
	        //		    $select->joinLeft($name, $cond)
	        $select->where ( "a.param_category_id = ?", $cat );
	        $select->where ( "a.param_category_desc <> ? ", '');
	
	    }
	    $rows = $this->fetchAll ( $select );
	    $rows=$rows->toArray();
	    $i=0;
	    foreach ($rows as $row)
	    {
	        if (is_null($rows[$i]['trvint_param_id']))
	        {
	            $rows[$i]['trvint_param_id']=$rows[$i]['param_id'];
	        }
	        if (is_null($row['trvint_cat'])) $rows[$i]['trvint_cat']=$rows[$i]['param_category_id'];
	        if (is_null($row['trvint_user_id'])) $rows[$i]['trvint_user_id']=$user_id;
	        $i++;
	    }
	    return $rows;
	}
	
	
}
