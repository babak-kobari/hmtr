
<?php
class Params_Model_reftable_Table extends Core_Db_Table_Abstract
{


    protected $_name = 'ref_table';



    public function getnewcode($old_code) {
        $select = $this->select ();
        $select->where ( 'old_id = ?',$old_code);
        return 	$this->fetchRow( $select );
    }
    
}
