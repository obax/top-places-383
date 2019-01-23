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

use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

use Symfony\Component\Routing\Annotation\Route;
use DateTime;


class FeedAPIController extends AbstractController
{
    /**
     * @SWG\Property(ref=@Model(type=FeedAPIController::class))
     */
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
        $indexPage->setTtl(3600);
        return $indexPage;
    }
    
    /**
     *
     * @param Request $request
     * @Route("/__services/top-places", name="app.controller.feeds", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Gets a combined feed",
     *     @SWG\Schema(
     *         type="json",
     *         @SWG\Items(ref=@Model(type=FeedAPIController::class, groups={"full"}))
     *     )
     * )
     *
     * @SWG\Parameter(
     *     in="path",
     *     name="city",
     *     type="string",
     *     required=true,
     *     description="Mandatory, to find which city is the center of attention"
     * )
     *
     * @SWG\Parameter(
     *     in="query",
     *     name="category",
     *     type="string",
     *     description="Allows fetching a location category"
     * )
     * @SWG\Parameter(
     *     in="query",
     *     name="provider",
     *     type="string",
     *     description="Allows narrowing the search to a data provider"
     * )
     * @SWG\Parameter(
     *     in="query",
     *     name="provider",
     *     type="string",
     *     description="Allows narrowing the search to a data provider"
     * )
     * @SWG\Parameter(
     *     in="query",
     *     name="min_rating",
     *     type="integer",
     *     description="Allows fetching data depending on a minimum user rating"
     * )

     *  @SWG\Parameter(
     *     in="query",
     *     name="max_price",
     *     type="integer",
     *     description="Allows fetching data depending on a maximum price"
     * )
     * @SWG\Tag(name="API Controller")
     * @return JsonResponse
     *
     */
    public function getData(Request $request)
    {
        $responseBody = [];
        $jsonResponse = new JsonResponse($responseBody);
        
        /** @var FeedRepository $cityRepo */
        $cityRepo = $this->em->getRepository(FeedEntity::class);
        if(!$request->query->has('city')){
            throw new \InvalidArgumentException('City missing');
        }
        $city = $request->query->get('city');
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
        
        if ($minRating = $request->query->get('min_rating', 0)) {
            if($minRating !== 0){
                $collection->filterGreaterThan('rating', $minRating);
            }
        }
        
        if ($maxPrice = $request->query->get('max_price', 0)) {
            $collection->filterLesserThan('price', $maxPrice);
        }
        
        return $jsonResponse->setData($collection);
    }
}