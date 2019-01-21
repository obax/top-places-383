<?php

namespace App\Controller;
use App\Entity\Feeds\FoursquareLocation;
use App\Entity\Feeds\LocationCollection;
use App\Entity\Feeds\TimeOutLocation;
use App\Repository\FeedRepository;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DataController extends AbstractController
{
/**
 * @var $client Client
 */
protected $client;

protected $em;

protected $endpointFSQ = 'http://www.mocky.io/v2/5c43d69d3800004100072e73';
protected $endpointTimeOut = 'http://www.mocky.io/v2/5c43dcd03800003913072e75';


public function __construct(EntityManagerInterface $em)
{
    $this->client = new Client();
    $this->em     = $em;
    // checks cache, then download if needed
}

/**
 * Accepts the following query parameters:
 * - category
 * - provider
 * - near (input is a name) calculation made on geo-similarity
 * - max-price
 * - min-rating
 *
 * @Route("/__services/top-places/{city}", name="app.controller.feeds", methods={"GET"})
 * @return JsonResponse
 */
public function getData($city, Request $request)
{
    /** @var FeedRepository $cityRepo */
    $cityRepo = $this->em->getRepository(FeedRepository::class);
    $endpoints = $cityRepo->byCity($city);
    
    if(count($endpoints) === 0){
        return new JsonResponse([]);
    }
    $response = $this->client->get($this->endpointTimeOut);
    $body = json_decode($response->getBody()->getContents());
    $allLocations = $body->data->locations;
    $collection = new LocationCollection();
    
    foreach ($allLocations as $location){
        $location = json_decode(json_encode($location), true);
        $location = new TimeOutLocation($location);
        $collection->add($location);
    }
    
    $criteria = [];
    
    if($category = $request->query->get('category'))
    {
        $criteria['category'] = $category;
    }
    if($provider = $request->query->get('provider'))
    {
        $criteria['provider'] = $provider;
    }
    if($near = $request->query->get('near'))
    {
        $criteria['near'] = $near;
    }
    if($minRating = $request->query->get('min-rating'))
    {
        $criteria['min-rating'] = $minRating;
    }
    if($maxPrice = $request->query->get('max-price'))
    {
        $criteria['max-price'] = $maxPrice;
    }
    
    $collection->filter($criteria);
    
    
    // calls repo for each city giving in turn list of feeds, depending on the placeholder
    //
    // turns the response into a normalized collection, calls data[location]
    // use the request query to build criteria
    return new JsonResponse();
}
}