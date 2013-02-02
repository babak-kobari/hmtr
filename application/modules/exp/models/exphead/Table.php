<?php

/**
 * poifacl
 *  
 * @author Babak
 * @version 
 */
class Exp_Model_exphead_Table extends Core_Db_Table_Abstract

{
	protected $_name = 'hm_exp_head';
	protected $_primary = 'exp_id';

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
	    ->from($this)
	        ->where ( 'exp_user_id = ?',$user_id );
	        if (count($filterArray) > 0) {
	            /*
	             * Filter array have some unwandet information
	            * Removing that information here
	            */
	            unset($filterArray['controller']);
	            unset($filterArray['action']);
	            unset($filterArray['module']);
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
	        foreach ($result as $key=>$row)
	        {
	            $result[$key]['country_name']=$country[$row['exp_country']];
	            $result[$key]['travel_With']=$travel_with[$row['exp_travel_with']];
	            $result[$key]['travel_Objective']=$travel_objective[$row['exp_travel_objective']];
	        }
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
	
}
