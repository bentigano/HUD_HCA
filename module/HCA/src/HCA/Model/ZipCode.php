<?php

namespace HCA\Model;

/**
 * ZipCode class.
 */
class ZipCode
{
    public $zip_code;
    public $latitude;
    public $longitude;
    public $city;
    public $state;
    public $county;
    
    /**
     * Exchanges array data into object variables.
     * 
     * @access public
     * @param mixed $data
     * @return void
     */
    public function exchangeArray($data)
    {
        $this->zip_code = (!empty($data['zip_code'])) ? $data['zip_code'] : null;
        $this->latitude = (!empty($data['latitude'])) ? $data['latitude'] : null;
        $this->longitude = (!empty($data['longitude'])) ? $data['longitude'] : null;
        $this->city = (!empty($data['city'])) ? $data['city'] : null;
        $this->state = (!empty($data['state'])) ? $data['state'] : null;
        $this->county = (!empty($data['county'])) ? $data['county'] : null;
    }
}