<?php
class Indirim_TrCityregion_Helper_Data extends Mage_Core_Helper_Abstract {
 protected $_cityJson;  //  resuts variable 
 protected $_countryCollection;
  
  public function getCountryCollection()
    {
        if (!$this->_countryCollection) {
            $this->_countryCollection = Mage::getModel('directory/country')->getResourceCollection()
                ->loadByStore();
        }
        return $this->_countryCollection;
    }
	
	
  public function getCityJson()
    {
//BEGIN Set up cache  for results 
        Varien_Profiler::start('TEST: '.__METHOD__);
        if (!$this->_cityJson) {
            $cacheKey = 'CITY_REGIONS_JSON_STORE'.Mage::app()->getStore()->getId();
            if (Mage::app()->useCache('config')) {
                $json = Mage::app()->loadCache($cacheKey);
            }
			// END 
			
			
            if (empty($json)) {
			// BEGIN LOAD all Turkish Cities
			 $resource = Mage::getSingleton('core/resource');
                 $readConnection = $resource->getConnection('core_read');
               //$regionIds = array();
				$cities = array();
				$query = "SELECT *
FROM `directory_country_region`
WHERE `country_id` = 'TR'";
$region_id = $readConnection->fetchAll($query);
// END 
                foreach ($region_id  as $region) {
                    
                
				//$collection = Mage::getModel('trcityregion/city')->load();
                
	// GET all couties in a city 				
  $query = "SELECT * FROM directory_country_city WHERE `region_code` = '$region[code]'"  ;
				 
				 $collection = $readConnection->fetchAll($query);
              // END 
// Create an array to hold results 			  
                foreach ($collection as $city) {
                    if (!$city['city_id']) {
                        continue;
                    }
					 
 

					
                    $cities[$region['region_id']][$city['default_name']] = array(
                        'code' => $city['region_code'],
                        'name' => $city['default_name'],
                    );
                }
	}

// END 	
// ENCODE data as Json				
                $json = Mage::helper('core')->jsonEncode($cities);

                if (Mage::app()->useCache('config')) {
                    Mage::app()->saveCache($json, $cacheKey, array('config'));
                }
            }
            $this->_cityJson = $json;
        }
		// END 
		
		// Output resuts as json 

        Varien_Profiler::stop('TEST: '.__METHOD__);
        return $this->_cityJson;
		 //END
		
		
		
		
    }
	
	


}