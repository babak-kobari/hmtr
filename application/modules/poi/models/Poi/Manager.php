<?php

/**
 * poi
 * 
 * @author Babak
 * @version 
 */
class Poi_Model_Poi_Manager extends Core_Model_Manager 

{
	public function getPoibyId($poi_id) {
		$poi_table = new Poi_Model_Poi_Table ();
		return $poi_table->getPoibyId ( $poi_id );
	}
	public function getPoiList(array $poicriteri, $pager, $short = false) {
		$poi_table = new Poi_Model_Poi_Table ();
		return $poi_table->getPoiList ( $poicriteri, $pager, $short = false );
	}
	
	public function getrelatedPoibyType($poi_id, $poi_type = null) {
		$table = new Poi_Model_Relatedpoi_Table ();
		$rows = $table->getPoibyType ( $poi_id, $poi_type );
		return $rows;
	}
	
	public function getPoiListbyType($poi_tpye, $paged = null, $shoert = false) {
		$table = new Poi_Model_Poi_Table ();
		$rows = $table->getPoiListbyType ( $poi_tpye );
		return $rows;
	}
	
	public function savePoi(Zend_Form $form, $info, $poi_id, $poi_type, $params, $images) {
		
		$poi_table = new Poi_Model_Poi_Table ();
		if (! is_null ( $poi_id )) {
			$row = $poi_table->getPoibyId ( $poi_id );
		} else
			$row = null;
		$info ['poi_type'] = $poi_type;
		$poi_id = $poi_table->saveRow ( $info, $row );
		$facl_table = new Poi_Model_Poifacl_Table ();
		if ($poi_type == 'Stay' and isset ( $info ['poi_amenities'] ))
			$facl_table->savefaclrows ( $info ['poi_amenities'], $poi_id, $params ['Amenities'], 'Amenities' );
		if ($poi_type == 'Eat' and isset ( $info ['poi_dining_options'] ))
			$facl_table->savefaclrows ( $info ['poi_dining_options'], $poi_id, $params ['Dining_Options'], 'Dining_Options' );
		if ($poi_type == 'Eat' and isset ( $info ['Cuisine'] ))
			$facl_table->savefaclrows ( $info ['Cuisine'], $poi_id, $params ['Cuisine'], 'Cuisine' );
		if ($poi_type == 'Things' and isset ( $info ['poi_things_options'] ))
			$facl_table->savefaclrows ( $info ['poi_things_options'], $poi_id, $params ['Things_options'], 'Things_options' );
		if ($poi_type == 'Things' and isset ( $info ['poi_things_activity'] ))
			$facl_table->savefaclrows ( $info ['poi_things_activity'], $poi_id, $params ['poi_things_activity'], 'Things_activity' );
			/*			 * Image renaming			 */
		if ($form->getElement ( 'poi_images' )->isUploaded ()) {
			$image_extension = pathinfo ( $form->getElement ( 'poi_images' )->getValue (), PATHINFO_EXTENSION );
			$form->getElement ( 'poi_images' )->addFilter ( 'Rename', array ('target' => time () . '.' . $image_extension, 'overwrite' => true ) );
			if (! $form->getElement ( 'poi_images' )->receive ()) {
				$messages = $form->getMgetMessages ();
				echo implode ( "\n", $messages );
				exit ();
			} else {
			}
			$images = $form->getElement ( 'poi_images' )->getValue (); //echo "<pre>";print_r($images);exit;	        	
			$image_table = new Poi_Model_Poiimages_Table ();
			$image_table->saveimagesrows ( $images, $poi_id );
		}
		
		return $poi_id;
	}
	public function saveRelatedPoiRow($info, $poi_id) {
		$related_table = new Poi_Model_relatedpoi_Table ();
		$row_id = $related_table->saveRelatedPoiRows ( $info, $poi_id );
		return $row_id;
	
	}
	public function deleteRelatedPoiRow($info, $poi_id) {
		$related_table = new Poi_Model_relatedpoi_Table ();
		$row_id = $related_table->deleteRelatedPoiRows ( $info, $poi_id );
		return $row_id;
	
	}
	public function getDefaultImage($poiid) {
		$image_table = new Poi_Model_Poiimages_Table ();
		return $image_table->getDefaultImage ( $poiid );
	}
	public function makeDefaultImage($poiid, $imgid) {
		$imageTable = new Poi_Model_Poiimages_Table ();
		return $imageTable->makeDefaultImage ( $poiid, $imgid );
	}
	public function getimagesbyPoiId($poiid) {
		$imageTable = new Poi_Model_Poiimages_Table ();
		return $imageTable->getimagesbyPoiId ( $poiid );
	}
	public function getImageName ($imgid) {
		$imageTable = new Poi_Model_Poiimages_Table();
		return $imageTable->getImagename($imgid);
	}
	public function deleteImage($imgid) {
		$imageTable = new Poi_Model_Poiimages_Table();
		return $imageTable->deleteImage($imgid);
	}

}
