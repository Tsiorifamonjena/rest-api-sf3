<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Place;
use FOS\RestBundle\Controller\Annotations\Get;

class PlaceController extends Controller
{
    /**
     * @Get("/places")
     */
    public function getPlacesAction(Request $request){
        
        $places = $this->get('doctrine.orm.entity_manager')->getRepository(Place::class)->findAll();
        $foramted = [];
        foreach($places as $place){
           $foramted[] = [
               'id' => $place->getId(),
               'name' => $place->getName(),
               'address' => $place->getAddress()
           ];
        }

        return new JsonResponse($foramted);
    }

    /**
     * @Get("/places/{place_id}", 
     *          name="place_one",
     *          requirements={"place_id" = "\d+"}
     * )
     */
    public function getPlaceAction(Request $request){
        $place = $this->get('doctrine.orm.entity_manager')->getRepository(Place::class)->find($request->get('place_id'));
        
        if(empty($place)){
            return new JsonResponse(['message' => 'ressource not found'], Response::HTTP_NOT_FOUND);
        }
        
        $foramted = [
            'id' => $place->getId(),
            'name' => $place->getName(),
            'address' => $place->getAddress()
        ];

        return new JsonResponse($foramted);
    }
}
?>