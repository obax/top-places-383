<?php
    
namespace App\Entity\Feeds;

abstract class Location
{
    protected $address;
    
    /** @var string $image */
    protected $image;
    
    /** @var string $name */
    protected $name;
    
    /** @var string $rating */
    protected $rating;
    
    /** @var string $link */
    protected $link;
    
    /** @var string $category */
    protected $category;
    
    /** @var string $price */
    protected $price;
    
    /** @var string $longitude */
    protected $longitude;
    
    /** @var string $latitude */
    protected $latitude;
    
    /** @var string $latitude */
    protected $description;
    
    abstract public function __construct(array $raw);
    
    abstract public function getProvider(): string;
    
    public function getImage(): string
    {
        return $this->image;
    }
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function getAddress(): string
    {
        return $this->address;
    }
    
    public function getDescription(): string
    {
        return $this->description;
    }
    
    public function getPrice(): string
    {
        return $this->price;
    }
    
    public function getCategory(): string
    {
        return $this->category;
    }
    
    public function getLatitude(): string
    {
        return $this->longitude;
    }
    
    public function getLongitude(): string
    {
        return $this->latitude;
    }
    
    public function getRating(): int
    {
        return $this->rating;
    }
    
    public function getURL(): string
    {
        return $this->link;
    }
}