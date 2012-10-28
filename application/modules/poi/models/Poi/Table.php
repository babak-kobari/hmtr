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
		$select->from ( 'hm_poi' );
		
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