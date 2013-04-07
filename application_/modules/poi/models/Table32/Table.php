<?php


class Poi_Model_Table32_Table extends Core_Db_Table_Abstract
{
	protected $_name = 'table_32';
	protected $_primary = 'id';
	
	public function getrowbyId($id) {
		$row = $this->find ( $id )->current ();
		return $row;
	}
	
}