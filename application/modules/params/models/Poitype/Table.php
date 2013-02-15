
<?php
class Params_Model_Poitype_Table extends Core_Db_Table_Abstract
{


    protected $_name = 'hm_param_poi_type';

    protected $_primary = 'param_id';


    public function getparambyId($param_id) {
        return $this->find ( $param_id )->current ();
    }
    public function getparamListbytype($type) {
        $select = $this->select ();
        $select->where ( 'poi_type = ?',$type)
        ->where('param_published = ?','P');
        return 	$this->fetchAll ( $select );
    }
    public function getparamListbygroup($group_id) {
        $select = $this->select ();
        $select->where ( 'poi_subtype_group = ?',$group_id)
        ->where('param_published = ?','P');
        return 	$this->fetchAll ( $select );
    }
    
}
