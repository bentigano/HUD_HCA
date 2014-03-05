<?php

namespace HCA\Model;

/**
 * Agency class.
 */
class Agency
{
    public $id;
    public $name;
    public $address1;
    public $address2;
    public $city;
    public $state;
    public $zip;
    public $phone1;
    public $phone2;
    public $fax;
    public $email;
    public $website;
    public $mailing_address1;
    public $mailing_address2;
    public $mailing_city;
    public $mailing_state;
    public $mailing_zip;
    public $parent_id;
    public $latitude;
    public $longitude;
    public $languages;
    public $services;
    public $faith_based;
    public $colonias;
    public $migrant_workers;
    public $status;
    public $source;
    public $counseling_method;
    public $last_updated;
    public $distance;
    
    /**
     * Exchanges array data into object variables.
     * 
     * @access public
     * @param mixed $data
     * @return void
     */
    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->name = (!empty($data['name'])) ? $data['name'] : null;
        $this->address1 = (!empty($data['address1'])) ? $data['address1'] : null;
        $this->address2 = (!empty($data['address2'])) ? $data['address2'] : null;
        $this->city = (!empty($data['city'])) ? $data['city'] : null;
        $this->state = (!empty($data['state'])) ? $data['state'] : null;
        $this->zip = (!empty($data['zip'])) ? $data['zip'] : null;
        $this->phone1 = (!empty($data['phone1'])) ? $data['phone1'] : null;
        $this->phone2 = (!empty($data['phone2'])) ? $data['phone2'] : null;
        $this->fax = (!empty($data['fax'])) ? $data['fax'] : null;
        $this->email = (!empty($data['email'])) ? $data['email'] : null;
        $this->website = (!empty($data['website'])) ? $data['website'] : null;
        $this->mailing_address1 = (!empty($data['mailing_address1'])) ? $data['mailing_address1'] : null;
        $this->mailing_address2 = (!empty($data['mailing_address2'])) ? $data['mailing_address2'] : null;
        $this->mailing_city = (!empty($data['mailing_city'])) ? $data['mailing_city'] : null;
        $this->mailing_state = (!empty($data['mailing_state'])) ? $data['mailing_state'] : null;
        $this->mailing_zip = (!empty($data['mailing_zip'])) ? $data['mailing_zip'] : null;
        $this->parent_id = (!empty($data['parent_id'])) ? $data['parent_id'] : null;
        $this->latitude = (!empty($data['latitude'])) ? $data['latitude'] : null;
        $this->longitude = (!empty($data['longitude'])) ? $data['longitude'] : null;
        $this->languages = (!empty($data['languages'])) ? $data['languages'] : null;
        $this->services = (!empty($data['services'])) ? $data['services'] : null;
        $this->faith_based = (!empty($data['faith_based'])) ? $data['faith_based'] : null;
        $this->colonias = (!empty($data['colonias'])) ? $data['colonias'] : null;
        $this->migrant_workers = (!empty($data['migrant_workers'])) ? $data['migrant_workers'] : null;
        $this->status = (!empty($data['status'])) ? $data['status'] : null;
        $this->source = (!empty($data['source'])) ? $data['source'] : null;
        $this->counseling_method = (!empty($data['counseling_method'])) ? $data['counseling_method'] : null;
        $this->last_updated = (!empty($data['last_updated'])) ? $data['last_updated'] : null;
        $this->distance = (!empty($data['distance'])) ? $data['distance'] : null;
    }
    
    /**
     * Calculates the distance (in miles) between the agency
     * and the given lat/long coordinates.
     * 
     * @access public
     * @param mixed $fromLatitude
     * @param mixed $fromLongitude
     * @return float Distance between the agency and passes in coordinates.
     */
    public function calculateDistance($fromLatitude, $fromLongitude)
    {
    	$pi80 = M_PI / 180;
    	$lat1 = $this->latitude * $pi80;
    	$lng1 = $this->longitude * $pi80;
    	$lat2 = $fromLatitude * $pi80;
    	$lng2 = $fromLongitude * $pi80;
     
    	$r = 6372.797; // mean radius of Earth in km
    	$dlat = $lat2 - $lat1;
    	$dlng = $lng2 - $lng1;
    	$a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
    	$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    	$km = $r * $c;
     
    	$this->distance = round($km * 0.621371192, 2);
    	return $this->distance;
    }
}