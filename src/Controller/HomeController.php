<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\Authorization;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route(path:'/')]
    public function home(
        Authorization $authorization,
        Request $request,
    ) : Response {
        /**
         * Authorization will be used to send a specific 'mercureAuthorization' cookie.
         *  This Cookie will be used for private topics
         * {@see BookController::updatePrivateBookStatus} for more information
         */
        $authorization->setCookie($request, ['*']);

        return $this->render('screens/home.html.twig');

    }
}
