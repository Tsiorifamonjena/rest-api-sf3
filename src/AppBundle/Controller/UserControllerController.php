<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\Get;

class UserControllerController extends Controller
{
    /**
     * @Get("/users", name="user_list")
     */
    public function getUsersAction(){
        $users = $this->get('doctrine.orm.entity_manager')->getRepository(User::class)->findAll();
        $formated = [];
        foreach($users as $user){
            $formated[] = [
                'id' => $user->getId(),
                'firstname' => $user->getFirstname(),
                'lastname' => $user->getLastname(),
                'email' => $user->getEmail()
            ];
        }

        return new JsonResponse($formated);
    }

    /**
     * @Get("/users/{user_id}", 
     *          name="user_one",
     *          requirements= {"user_one"="\d+"}
     * )
     */
    public function getUserAction(Request $request){
        $user = $this->get('doctrine.orm.entity_manager')->getRepository(User::class)->find($request->get('user_id'));
        
        if(empty($user)){
            return new JsonResponse(['message' => 'ressource not found'], Response::HTTP_NOT_FOUND);
        }
        
        $formated = [
            'id' => $user->getId(),
            'firstname' => $user->getFirstname(),
            'lastname' => $user->getLastname(),
            'email' => $user->getEmail()
        ];

        return new JsonResponse($formated);
    }
}
