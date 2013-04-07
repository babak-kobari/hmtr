
<?php
class Params_Model_Hotelchain_Table extends Core_Db_Table_Abstract
{


    protected $_name = 'hm_param_hotel_chain';

    protected $_primary = 'param_id';


    public function getparambyId($param_id) {
        return $this->find ( $param_id )->current ();
    }
    public function getHotelchainAll() {
        $select = $this->select ();
        $select->where('param_published = ?','P');
        return 	$this->fetchAll ( $select );
    }
    
}
