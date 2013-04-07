<?php
class Poi_Model_poiimages_Row extends Core_Db_Table_Row_Abstract
{
    
    public function isDefault() {
		if ($this->poiimg_Default == 1)
			return true;
		else
			return false;
	}
}