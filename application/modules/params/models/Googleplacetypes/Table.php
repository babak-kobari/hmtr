
<?php
class Params_Model_Googleplacetypes_Table extends Core_Db_Table_Abstract
{


    protected $_name = 'hm_param_google_place_type';

    protected $_primary = 'id';


    public function gettypebygooglecode($google_place_type) {
        $select = $this->select ();
        $select->where('google_place_type = ?',$google_place_type);
        return 	$this->fetchRow ( $select );
    }
    
}
