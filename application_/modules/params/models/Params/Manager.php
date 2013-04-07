<?php

/**
 * poi
 *  
 * @author Babak
 * @version 
 */
class Params_Model_Params_Manager extends Core_Model_Manager

{
    
	public function getcountryId($country_id) {
	    $table=new Params_Model_Countries_Table();
		return $table->getcountryId($country_id);
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

	public function getPoiParambyType($type)
	{
	    $table = new Params_Model_Poitype_Table();
	    return $table->getparamListbytype($type);
	}

	public function getPoiParambygroup($group_id)
	{
	    $table = new Params_Model_Poitype_Table();
	    return $table->getparamListbygroup($group_id);
	}
	
	public function getTdolist()
	{
	    $table = new Params_Model_Tdotype_Table();
	    return $table->getTdoList();
	}
	
	public function getTravelStyleAll()
	{
	    $table = new Params_Model_Travelstyle_Table();
	    return $table->getparamList();
	}
	public function getTravelwithAll()
	{
	    $table = new Params_Model_Travelwith_Table();
	    return $table->getparamList();
	}
	public function getTravelOpjectiveAll()
	{
	    $table = new Params_Model_Travelobjective_Table();
	    return $table->getparamList();
	}
	public function getGoodForAll()
	{
	    $table = new Params_Model_Goodfor_Table();
	    return $table->getparamList();
	}
	
	public function getLocationtypeAll()
	{
	    $table = new Params_Model_Locationtype_Table();
	    return $table->getLocationtypeAll();
	}
	public function getStayClassificationAll()
	{
	    $table = new Params_Model_Stayclassification_Table();
	    return $table->getStayClassificationAll();
	}
	public function getPoiOptionTypes($option_type)
	{
	    $table = new Params_Model_Poioptions_Table();
	    return $table->getparamListbyType($option_type);
	}
	public function gethotelchainAll()
	{
	    $table = new Params_Model_Hotelchain_Table();
	    return $table->getHotelchainAll();
	}
	public function gethotelchainbyid($param_id)
	{
	    $table = new Params_Model_Hotelchain_Table();
	    return $table->getparambyId($param_id)->toArray();
	}
	
}