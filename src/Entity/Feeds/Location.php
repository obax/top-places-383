<?php
    
namespace App\Entity\Feeds;

abstract class Location
{
    public $address;
    
    /** @var string $image */
    public $image;
    
    /** @var string $name */
    public $name;
    
    /** @var int $rating */
    public $rating = 5;
    
    /** @var string $link */
    public $link;
    
    /** @var string $category */
    public $category;
    
    /** @var int $price */
    public $price = 0;
    
    /** @var string $longitude */
    public $longitude;
    
    /** @var string $latitude */
    public $latitude;
    
    /** @var string $latitude */
    public $description;
    
    /** @var string $provider */
    public $provider;
    
    public function sanitizePrices($text)
    {
        if(preg_match('/[\$\£]([\d,]+(\.[\d]{2})?)/u',$text,$matches)){
            $this->price =  $matches[1];
        }
    }
    
    abstract public function __construct(array $raw);
}