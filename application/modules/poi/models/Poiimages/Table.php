<?php

/**
 * poifacl
 *  
 * @author Babak
 * @version 
 */
require_once dirname ( __FILE__ ) . '/Rows/Rows.php';
class Poi_Model_Poiimages_Table extends Core_Db_Table_Abstract
{
    protected $_name = 'hm_poi_images';
	protected $_primary = 'poiimg_id';
	protected $_rowClass = 'Poi_Model_poiimages_Row';
	protected $_referenceMap = array (
			'RelatedPoi' => array (
					'columns' => array (
							'poiimg_poi_id' 
					),
					'refTableClass' => 'Poi_Model_Poi_Table',
					'refColumns' => array (
							'poi_id' 
					) 
			) 
	);
	public function getpoiimagebyId($poiimg_id) {
		return $this->find ( $poiimg_id )->current ();
	}
	public function getimagesbyPoiId($poi_id) {
		$select = new $this->select ();
		$select->from ( 'ph_poi_images' );
		$select->where ( 'poiimg_poi_id = ?', $poi_id );
		return $this->fetchAll ( $select );
	}
	public function saveimagesrows($info, $poi_id) 
	{
	    if (null==$info)
	        return true;
		$rowdata=array (
					'poiimg_poi_id' => $poi_id,
					'poiimg_path' => $info,
			        'poiimg_default'=>'0');
			        $row_id=$this->insert($rowdata);
				
	}
	/*
	 * public function getpoifaclList($Param_Type,$Param_Category_id=null) {
	 * $select = $this->select(); $select->from('hm_poi_param')
	 * ->where("param_type = ?" , $Param_Type) ->where("param_category_id = ?",
	 * $Param_Category_id); return $this->fetchAll($select); }
	 */
}
