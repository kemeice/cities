<?php
// Creating Collection For module Kemeice March 2 2014
class Indirim_TrCityregion_Model_Mysql4_City_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
 public function _construct()
    {
        parent::_construct();
        $this->_init('trcityregion/city');

}
// END