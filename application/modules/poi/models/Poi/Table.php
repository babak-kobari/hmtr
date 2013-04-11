<?php

require_once dirname ( __FILE__ ) . '/Rows/Rows.php';

class Poi_Model_Poi_Table extends Core_Db_Table_Abstract
{
	protected $_name = 'hm_poi';
	protected $_primary = 'poi_id';
	protected $_rowClass = 'Poi_Model_Poi_Row';
	protected $_dependentTables = array (
			'Poi_Model_poifacl_Table');
	
	public function getPoibyId($poi_id) {
		$row = $this->find ( $poi_id )->current ();
		return $row;
	}
	
	public function getPoibyName($poi_name) {
		return $this->fetchRow ( $this->select ()->where ( 'poi_name = ?' ), $poi_name );
	}
	public function getTotalPois(array $poi_criteria) {
		$select = $this->select ();
		$select->setIntegrityCheck(false);
		$select->from ( array("poi" => "hm_poi"),array("count(poi_id) as totalRecods") );
		if(count($poi_criteria) > 0){
	
			if (isset($poi_criteria['filterval'])) {
				$filterval = $poi_criteria['filterval'];
				//$select->where("poi_area LIKE '%$filterval%'");
				$select->where("poi_name LIKE '%$filterval%'");
			}
			if (isset($poi_criteria['poi_id'])) {
				$select->where("poi_id  = ?",$poi_criteria['poi_id']);
			}
			if (isset($poi_criteria['poi_country'])) {
				$select->where("poi_country  = ?",$poi_criteria['poi_country']);
			}
			if (isset($poi_criteria['poi_type'])) {
			    $select->where("poi_type  = ?",$poi_criteria['poi_type']);
			}
				
		}
		return $this->fetchAll ( $select );
	}
	public function getPoiList(array $poi_criteria, $paged = null, $short = false) {
		$select = $this->select ();
		$select->setIntegrityCheck(false);
		$select->from ( array("poi" => "hm_poi") );
		if (!$short)
		{
		    $select->join ( array("type" => "hm_param_poi_type"),'type.param_id=poi.poi_sub_type' ,array("stayname" => "type.param_desc"));
		    $select->join ( array("htgroup" => "hm_param_hotel_chain"),'htgroup.param_id=poi.poi_group_name',array("groupname" => "htgroup.param_desc") );
		}

		if(count($poi_criteria) > 0){
			
			if (isset($poi_criteria['filterval'])) {
				$filterval = $poi_criteria['filterval'];
				//$select->where("poi_area LIKE '%$filterval%'");
				$select->where("poi_name LIKE '%$filterval%'");
			}
			if (isset($poi_criteria['poi_id'])) {
				$select->where("poi_id  = ?",$poi_criteria['poi_id']);
			}
			if (isset($poi_criteria['poi_country'])) {
			    $select->where("poi.poi_country  = ?",$poi_criteria['poi_country']);
			}
			if (isset($poi_criteria['poi_type'])) {
			    $select->where("poi.poi_type  = ?",$poi_criteria['poi_type']);
			}
				
		}
		
		//$select->where('hmimage.poiimg_default = ?', '1');
		//print $select->__toString();exit;
		if (null !== $paged) {
			/*$adapter = new Zend_Paginator_Adapter_DbTableSelect ( $select );
			//var_dump($adapter);exit;
			$count = clone $select;
			$count->reset ( Zend_Db_Select::COLUMNS );
			$count->reset ( Zend_Db_Select::FROM );
			$count->from ( 'hm_poi', new Zend_Db_Expr ( 'COUNT(*) AS `zend_paginator_row_count`' ) );
			$adapter->setRowCount ( $count );
			$paginator = new Zend_Paginator ( $adapter );
			$paginator->setItemCountPerPage ( 5 )->setCurrentPageNumber ( ( int ) $paged );*/
			$select->limitPage($paged,10);
		}
		//print $select->__toString();exit;
		return $this->fetchAll ( $select );
	}
	
	public function getPoiListbyType($poi_tpye, $paged = null, $shoert = false , $country = null) {
	    $select = $this->select ();
	    $select->from ( 'hm_poi' );
	    $select->where('poi_type = ?',$poi_tpye)
	           ->where('poi_country = ?', $country);
	
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