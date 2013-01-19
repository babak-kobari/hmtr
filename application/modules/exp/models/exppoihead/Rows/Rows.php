<?php
class Exp_Model_exppoihead_Row extends Core_Db_Table_Row_Abstract

{
    public function getexppoiFacl($group_id)
    {
        $select = $this->select();
//        $select->from($this);
        $select->where('poifcl_param_category_id = ?',$group_id);
//	     $select->setIntegrityCheck(false);
//         $select->join(array('a'=>'hm_param'), 'a.param_id = exp_poi_param_id',
//                        array('a.param_category_desc'));
                return $this->findDependentRowset ( 'Exp_Model_exppoidetail_Table',null,$select );
    }
    
}