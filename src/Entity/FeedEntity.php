<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FeedRepository")
 * @ORM\Table(name="feed_list")
 */
class FeedEntity
{
    /**
     * @var $id int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $city;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $uri;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $provider;
    
    /**
     * @var $version int
     * @ORM\Column(type="integer")
     */
    protected $version;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $moreLink;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $latitude;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $longitude;
    
    /**
     * @return mixed
     */
    public function getUri()
    {
        return $this->uri;
    }
}