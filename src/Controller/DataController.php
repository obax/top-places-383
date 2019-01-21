<?php

namespace App\Controller;

use App\Entity\FeedEntity;
use App\Entity\Feeds\FoursquareLocation;
use App\Entity\Feeds\Location;
use App\Entity\Feeds\LocationCollection;
use App\Entity\Feeds\TimeOutLocation;
use App\Entity\Feeds\ViatorLocation;
use App\Repository\FeedRepository;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Routing\Annotation\Route;
use DateTime;

class DataController extends AbstractController
{
    private const FIVE_MIN = 300;
    
    /** @var $client Client */
    protected $client;
    
    protected $em;
    
    public function __construct(EntityManagerInterface $em)
    {
        $this->client = new Client();
        $this->em = $em;
        // checks cache, then download if needed
    }
    
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $indexPage = $this->render('search.html.twig');
        return $indexPage;
    }
    
    /**
     * Accepts the following query parameters:
     * - category
     * - provider
     * - near (input is a name) calculation made on geo-similarity
     * - max-price
     * - min-rating
     *
     * @param string $city
     * @param Request $request
     * @Route("/__services/top-places/{city}", name="app.controller.feeds", methods={"GET"})
     * @return JsonResponse
     */
    public function getData($city, Request $request)
    {
        $responseBody = [];
        $jsonResponse = new JsonResponse($responseBody);
        
        /** @var FeedRepository $cityRepo */
        $cityRepo = $this->em->getRepository(FeedEntity::class);
        $feeds = $cityRepo->byCity($city);
        
        $dataFreshFor = self::FIVE_MIN;
        $now = (new DateTime('now'))->getTimestamp();
        
        if (empty(count($feeds))) {
            return $jsonResponse;
        }
        $collection = new LocationCollection();
        
        foreach ($feeds as $feed) {
            $response = $this->client->get($feed['uri']);
            if ($response->getStatusCode() === 200 && $response->hasHeader('Expires')) {
                $expiration = (new DateTime($response->getHeader('Expires')[0]))->getTimestamp();
                // get the lowest value of all the feeds, so the concatenated version is going to be correct
                $currentFeedExpiry = $expiration - $now;
                $dataFreshFor = ($currentFeedExpiry < $dataFreshFor) ? $currentFeedExpiry : $dataFreshFor;
            }
            
            $body = json_decode($response->getBody()->getContents());
            
            /** @var Location[] $places */
            $places = $body->data->locations;
            
            foreach ($places as $location) {
                $location = json_decode(json_encode($location), true);
                switch ($feed['provider']) {
                    case 'Foursquare':
                        $location = new FoursquareLocation($location);
                        break;
                    case 'TimeOut':
                        $location = new TimeOutLocation($location);
                        break;
                    case 'Viator':
                        $location = new ViatorLocation($location);
                        break;
                }
                $collection->add($location);
            }
        }
        
        $jsonResponse->setMaxAge($dataFreshFor);
        
        if ($category = $request->query->get('category')) {
            $collection->filterEquals('category', $category);
        }
        
        if ($provider = $request->query->get('provider')) {
            $collection->filterEquals('provider', $provider);
        }
        
        if ($minRating = $request->query->get('min_rating')) {
            $collection->filterGreaterThan('rating', $minRating);
        }
        
        if ($maxPrice = $request->query->get('max_price')) {
            $collection->filterLesserThan('price', $maxPrice);
        }
        
        return $jsonResponse->setData($collection);
    }
}