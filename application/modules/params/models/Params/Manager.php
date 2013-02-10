<?php

/**
 * poi
 *  
 * @author Babak
 * @version 
 */
class Params_Model_Params_Manager extends Core_Model_Manager

{

	public function getcountryId($param_id) {
	    $table=new Params_Model_Countries_Table();
		return $table->getcountryId($param_id);
	}
	public function getcountryList($searchstring) {
	    $table=new Params_Model_Countries_Table();
		return 	$table->getcountryList($searchstring);
	}
	public function getcountrybyCode($code) {
	    $table=new Params_Model_Countries_Table();
	    return $table->getcountrybyCode($code);
	}
	public function getcountryAll() {
	    $table=new Params_Model_Countries_Table();
	    return $table->getcountryAll();
	}
	
	public function getcityId($param_id) {
	    $table = new Params_Model_Cities_Table();
	    return $table->getcityId($param_id);
	}
	public function getcityList($searchstring,$code) {
	    $table = new Params_Model_Cities_Table();
	    return $table->getcityList($searchstring, $code);
	}
	
}