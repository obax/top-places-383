<?php

namespace App\Entity\Feeds;

use JsonSerializable;

class LocationCollection implements JsonSerializable
{
    public function jsonSerialize()
    {
       return array_values($this->locations);
    }
    
    /** @var Location[] */
    protected $locations = [];
    
    public function add(Location $location)
    {
        $this->locations[] = $location;
    }
    
    public function filterEquals($field, $value)
    {
        if(property_exists(Location::class, $field) && ($value !== '')){
            $this->locations = array_filter($this->locations, function (Location $location) use ($field, $value){
                return strtolower($location->{$field}) === strtolower($value);
            });
        }
    }
    
    public function filterGreaterThan($field, $value)
    {
        if(property_exists(Location::class, $field)){
            $this->locations = array_filter($this->locations, function (Location $location) use ($field, $value){
                if(!empty($location->{$field})) {
                    return (int)$location->{$field} > (int)$value;
                }
            });
        }
    }
    
    public function filterLesserThan($field, $value)
    {
        if(property_exists(Location::class, $field)){
            $this->locations = array_filter($this->locations, function (Location $location) use ($field, $value){
                if(!empty($location->{$field})){
                    return (int)$location->{$field} < (int)$value;
                }
            });
        }
    }
    
    public function sort()
    {
        //usort
    }
}