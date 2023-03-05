<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route(path:'/')]
    public function home() : Response 
    {
        
        /** @return Response */
        return $this->render('screens/home.html.twig', [
            
        ]);
    }
}
