<?php
class Poi_Model_relatedpoi_Row extends Core_Db_Table_Row_Abstract

{
    public function getPoi_data() 
    {
        return $this->findParentRow ( 'Poi_Model_Poi_Table', 'relatedPoi' );
    }
    
}