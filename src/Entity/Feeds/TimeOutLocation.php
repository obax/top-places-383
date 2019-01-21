<?php

namespace App\Entity\Feeds;

final class TimeOutLocation extends Location
{
    public function __construct(array $raw)
    {
        $this->address   = $raw['address'];
        $this->image     = $raw['image'];
        $this->name      = $raw['name'];
        $this->rating    = $raw['rating'];
        $this->link      = $raw['link'];
        $this->category  = $raw['category'];
        $this->longitude = $raw['longitude'];
        $this->latitude  = $raw['latitude'];
        $this->description  = $raw['description'];
        $this->sanitizePrices($raw['price']);
        $this->provider  = 'TimeOut';
    }
    
//featured	false
//start_date	null
//end_date	null
}