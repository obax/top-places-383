<?php

namespace App\Entity\Feeds;

final class FoursquareLocation extends Location
{
    public function getProvider(): string
    {
        return 'Foursquare';
    }
    
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
    }
}