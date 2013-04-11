<?php

require_once dirname ( __FILE__ ) . '/Rows/Rows.php';

class Exp_Model_Exp_Table extends Core_Db_Table_Abstract
{
	protected $_name = 'hm_exp_head';
	protected $_primary = 'exp_id';
	protected $_rowClass = 'Exp_Model_Exp_Row';
	protected $_referenceMap = array (
	'travel_with' => array (
	        'columns' => 'exp_travel_with',
	        'refTableClass' => 'Params_Model_Travelwith_Table',
	        'refColumns' => 'param_id'),
	'travel_objective' => array (
	         'columns' => 'exp_travel_objective' ,
	         'refTableClass' => 'Params_Model_Travelobjective_Table',
	         'refColumns' => 'param_id')
	);
	protected $_dependentTables = array (
	      'Exp_Model_Expdays_Table',
	      'Exp_Model_Exppoihead_Table');
	
	
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
	public function getexpheadbyId($exp_id)
	{
	    $select = $this->select()
	    ->from($this)
	    ->where ( 'exp_id = ?',$exp_id );
	    $row=$this->find($exp_id)->current();
	    return $row;
	}
	
	public function getcountriesbyUser($user_id)
	{
	    $select = $this->select()
	    ->distinct()
	    ->from($this,'exp_country')
	    ->where ( 'exp_user_id = ?',$user_id );
	    $rows=$this->fetchAll($select)->toArray();
	    return $rows;
	}
	
	public function getTotalWIP ($user_id) {
	    try{
	        $select = $this->select()
	        ->from($this,array('count(*) as total'))
	        ->where ( 'exp_user_id = ?',$user_id )
	        ->where('exp_status = ?','WIP');
	        $count= $this->fetchRow($select);
	        return $count->total;
	    }catch (Exception $e) {
	        throw new Exception($e->getMessage());
	    }
	}
	
	public function getExpDetails ($user_id,array $filterArray,&$country,&$travel_with,&$travel_objective) {
	
	    try{
	        $select = $this->select()
	        ->setIntegrityCheck(false)
	        ->from($this)
	        ->join('hm_param_travel_with', 'hm_param_travel_with.param_id=hm_exp_head.exp_travel_with',array('travel_with'=>'param_desc'))
	        ->join('hm_param_travel_objective', 'hm_param_travel_objective.param_id=hm_exp_head.exp_travel_objective',array('travel_objective'=>'param_desc'))
	        ->join('hm_param_country', 'hm_param_country.country_id=hm_exp_head.exp_country','country_name')
	        ->where ( 'exp_user_id = ?',$user_id );
	        if (count($filterArray) > 0) {
	            /*
	             * Filter array have some unwandet information
	            * Removing that information here
	            */
	            unset($filterArray['controller']);
	            unset($filterArray['action']);
	            unset($filterArray['module']);
	            if (isset($filterArray['status']))
	            {
	                unset($filterArray['status']);
	            }
	            if (isset($filterArray['exp_id']))
	            {
	                unset($filterArray['exp_id']);
	            }
	             
	            foreach ($filterArray as $k => $v) {
	                /*
	                 * Buiding dynamic where conditions
	                * for creating where condtions the value must be non-empty
	                */
	                if (strlen(trim($v)) > 0 ) {
	                    $select->where($k ." = '".$v."'");
	                }
	            }
	        }
	        $result = $this->fetchAll($select)->toArray();
	        return $result;
	    }catch (Exception $e) {
	        throw new Exception($e->getMessage());
	    }
	}
	public function getTitles($searchString) {
	    try {
	        $result = array();
	        $select = $this->select()
	        ->from($this,array('exp_title as title'));
	        $select->where("exp_title LIKE '%".$searchString."%'");
	        $result= $this->fetchAll($select);
	        $rtArray = array ();
	        if (count($result) > 0) {
	            foreach ($result as $r) {
	                $rtArray[] = $r['title'];
	            }
	        }
	        return $rtArray;
	    }catch (Exception $e) {
	        throw new Exception($e->getMessage());
	    }
	}
	public function getCityNames($searchString) {
	    try {
	        $result = array();
	        $select = $this->select()
	        ->from($this);
	
	        $select->columns(
	                array('exp.exp_city as city')
	        );
	        $select->where("exp.exp_city LIKE '%".$searchString."%'");
	        $result= $this->fetchAll();
	        $rtArray = array ();
	        if (count($result) > 0) {
	            foreach ($result as $r) {
	                $rtArray[] = $r['city'];
	            }
	        }
	        return $rtArray;
	    }catch (Exception $e) {
	        throw new Exception($e->getMessage());
	    }
	}
	public function deleteexpheadbyexpId($exp_id)
	{
	    $this->delete('exp_id = '.$exp_id);
	}
	
	public function expchangestatusbyexpId($exp_id,$status)
	{
	    $data = array('exp_status'=> $status);
	    $where = 'exp_id = '.$exp_id;
	    $this->update($data,$where);
	     
	}
	
}