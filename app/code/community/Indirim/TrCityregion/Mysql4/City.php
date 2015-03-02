<?php

// Creating Modal for extension Kemeice March 2014
class Indirim_TrCityregion_Model_Model_Mysql4_City extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        $this->_init('trcityregion/city', 'city_id');
    }
}
// END