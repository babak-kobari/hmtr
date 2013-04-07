<?php

require_once dirname ( __FILE__ ) . '/Rows/Rows.php';

class Poi_Model_Poi_Table extends Core_Db_Table_Abstract
{
	protected $_name = 'hm_poi';
	protected $_primary = 'poi_id';
	protected $_rowClass = 'Poi_Model_Poi_Row';
	protected $_referenceMap = array (
			'stay_type' => array (
					'columns' => 'poi_stay_type',
					'refTableClass' => 'Users_Model_Param_Table',
					'refColumns' => 'param_id'),
			'stay_class' => array (
					'columns' => 'poi_stay_calssification' ,
					'refTableClass' => 'Users_Model_Param_Table',
					'refColumns' => 'param_id'),
			'location_type' => array (
					'columns' => 'poi_location_type',
					'refTableClass' => 'Users_Model_Param_Table',
					'refColumns' => 'param_id') 
	);
	protected $_dependentTables = array (
			'Poi_Model_poifacl_Table');
	
	public function getPoibyId($poi_id) {
		$row = $this->find ( $poi_id )->current ();
		return $row;
	}
	
	public function getPoibyName($poi_name) {
		return $this->fetchRow ( $this->select ()->where ( 'poi_name = ?' ), $poi_name );
	}
	public function getPoiList(array $poi_criteria, $paged = null, $shoert = false) {
		$select = $this->select ();
		$select->setIntegrityCheck(false);
		$select->from ( array("poi" => "hm_poi") );
		$select->join ( array("type" => "hm_param_poi_type"),'type.param_id=poi.poi_stay_type' ,array("stayname" => "type.param_desc"));
		$select->join ( array("htgroup" => "hm_param_hotel_chain"),'htgroup.param_id=poi.poi_group_name',array("groupname" => "htgroup.param_desc") );
		//$select->joinLeft(array("hmimage" => "hm_poi_images"),'hmimage.poiimg_poi_id=poi.poi_id',array("imagepath" => "hmimage.poiimg_path"));
		if(count($poi_criteria) > 0){
			
			if (isset($poi_criteria['filterval'])) {
				$filterval = $poi_criteria['filterval'];
				//$select->where("poi_area LIKE '%$filterval%'");
				$select->where("poi_name LIKE '%$filterval%'");
			}
			if (isset($poi_criteria['poi_id'])) {
				$select->where("poi_id  = ?",$poi_criteria['poi_id']);
			}
		}
		
		//$select->where('hmimage.poiimg_default = ?', '1');
		//print $select->__toString();exit;
		if (null !== $paged) {
			$adapter = new Zend_Paginator_Adapter_DbTableSelect ( $select );
			//var_dump($adapter);exit;
			$count = clone $select;
			$count->reset ( Zend_Db_Select::COLUMNS );
			$count->reset ( Zend_Db_Select::FROM );
			$count->from ( 'hm_poi', new Zend_Db_Expr ( 'COUNT(*) AS `zend_paginator_row_count`' ) );
			$adapter->setRowCount ( $count );
			$paginator = new Zend_Paginator ( $adapter );
			$paginator->setItemCountPerPage ( 5 )->setCurrentPageNumber ( ( int ) $paged );
		}
		return $this->fetchAll ( $select );
	}
	
	public function getPoiListbyType($poi_tpye, $paged = null, $shoert = false) {
	    $select = $this->select ();
	    $select->from ( 'hm_poi' );
	    $select->where('poi_type = ?',$poi_tpye);
	
	    if (null !== $paged) {
	        $adapter = new Zend_Paginator_Adapter_DbTableSelect ( $select );
	        $count = clone $select;
	        $count->reset ( Zend_Db_Select::COLUMNS );
	        $count->reset ( Zend_Db_Select::FROM );
	        $count->from ( 'hm_poi', new Zend_Db_Expr ( 'COUNT(*) AS `zend_paginator_row_count`' ) );
	        $adapter->setRowCount ( $count );
	        $paginator = new Zend_Paginator ( $adapter );
	        $paginator->setItemCountPerPage ( 5 )->setCurrentPageNumber ( ( int ) $paged );
	    }
	    return $this->fetchAll ( $select );
	}
}