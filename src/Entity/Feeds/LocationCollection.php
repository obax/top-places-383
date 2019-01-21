<?php

namespace App\Entity\Feeds;

use JsonSerializable;

class LocationCollection implements JsonSerializable
{
    public function jsonSerialize()
    {
       return [];
    }
    
    protected $locations = [];
    
    public function add(Location $location)
    {
        $this->locations[] = $location;
    }
    
    public function filter($criteria)
    {
        //array_map?
    }
    
    public function sort()
    {
        //usort
    }
    
}