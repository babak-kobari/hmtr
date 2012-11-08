<?php

/**
 * poi
 *  
 * @author Babak
 * @version 
 */
class Poi_Model_Poi_Manager extends Core_Model_Manager

{
	public function getPoibyId($poi_id) 
	{
	    $poi_table=new Poi_Model_Poi_Table();
		return $poi_table->getPoibyId ( $poi_id );
	}
	public function getPoiList(array $poicriteri, $pager, $short = false)
	{
	    $poi_table= new Poi_Model_Poi_Table();
		return $poi_table->getPoiList ( $poicriteri, $paged = null, $short = false );
	}
	
	public function getrelatedPoibyType($poi_id,$poi_type = null)
	{
	    $table= new Poi_Model_relatedpoi_Table();
	    $rows = $table->getPoibyType($poi_id, $poi_type);
	    return $rows;
	}

	public function getPoiListbyType($poi_tpye, $paged = null, $shoert = false) 
	{
	    $table= new Poi_Model_Poi_Table();
	    $rows=$table->getPoiListbyType($poi_tpye);
	    return $rows;
	}
	
	public function savePoi(Zend_Form $form,$info,$poi_id,$poi_type,$params,$images) 
	{
		
	        $poi_table= new Poi_Model_Poi_Table();
	        if (!is_null($poi_id))
	        {
	            $row=$poi_table->getPoibyId($poi_id);
	        }
	        else 
	            $row=null;
	        $info['poi_type']=$poi_type;
	        $poi_id = $poi_table->saveRow ( $info, $row );
	        $facl_table=new Poi_Model_poifacl_Table();
	        if ($poi_type=='Stay'and isset($info ['poi_amenities']))
    	        $facl_table->savefaclrows ( $info ['poi_amenities'], $poi_id,$params['Amenities'],'Amenities' );
	        if ($poi_type=='Eat' and isset($info ['poi_dining_options']))
    	        $facl_table->savefaclrows ( $info ['poi_dining_options'], $poi_id,$params['Dining_Options'],'Dining_Options' );
	        if ($poi_type=='Eat' and isset($info ['Cuisine']))
    	        $facl_table->savefaclrows ( $info ['Cuisine'], $poi_id,$params['Cuisine'],'Cuisine' );
	        $form->getElement ( 'poi_images' )->receive ();
	        $images=$form->getElement ( 'poi_images' )->getValue();
	        $image_table=new Poi_Model_poiimages_Table();
	        $image_table->saveimagesrows( $images, $poi_id);
	         
		
		return $poi_id;
	}
	public function getParambyId($Param_id) {
		return $this->getResource ( 'Param' )->getParambyId ( $Param_id );
	}
	public function getParamList($param_Type, $Param_Category_Type = null) {
		return $this->getResource ( 'Param' )->getParamList ( $param_Type, $Param_Category_Type );
	}
	public function getimagesbyPoiId($Poi_id) {
		return $this->getResource ( 'poimain' )->getimagesbyPoiId ( $poi_Id );
	}
	
}
