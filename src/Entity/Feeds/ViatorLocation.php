<?php

namespace App\Entity\Feeds;

final class ViatorLocation extends Location
{
    public function __construct(array $raw)
    {
        $this->address   = $raw['address'];
        $this->image     = $raw['image_thumb'];
        $this->name      = $raw['name'];
        $this->rating    = $raw['rating'];
        $this->link      = $raw['link'];
        $this->category  = $raw['category'];
        $this->longitude = $raw['longitude'];
        $this->latitude  = $raw['latitude'];
        $this->description  = $raw['description'];
        $this->sanitizePrices($raw['price']);
        $this->provider  = 'Viator';
    }

//    duration	"1 day"
//    rating_count	null
//    image_thumb	"https://media.tacdn.com/media/attractions-splice-spp-154x109/06/75/6c/bf.jpg"
//    image_large	"https://media.tacdn.com/media/attractions-splice-spp-674x446/06/75/6c/bf.jpg"
//    featured	false
//    start_date	null
//    end_date	null
}