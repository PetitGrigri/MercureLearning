<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\Authorization;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ExampleController extends AbstractController
{
    #[Route(path:'/simple-subscription', name: 'simple_subscription')]
    public function simpleSubscription() : Response
    {
        return $this->render('screens/simple_subscription.html.twig');
    }

    #[Route(path:'/multiple-subscriptions', name: 'multiple_subscriptions')]
    public function multipleSubscriptions() : Response
    {
        return $this->render('screens/multiple_subscriptions.html.twig');
    }

    #[Route(path:'/private-subscription', name: 'private_subscription')]
    public function privateSubscription(
        Authorization $authorization,
        Request $request,
    ) : Response
    {
        // The allowed topic (first book)
        // You can update the allowed id manually to test
        $topic = $this->generateUrl(
            'get_private_book',
            ['id' => 1],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        /**
         * Authorization will be used to send a specific 'mercureAuthorization' cookie.
         *  This Cookie will be used for private topics
         *
         * {@see BookController::updatePrivateBookStatus} for more information
         */
        $authorization->setCookie($request, [$topic]); // only the first topic will be allowed
        // $authorization->setCookie($request, ['*']); // All topics will be allowed

        return $this->render('screens/private_subscription.html.twig');
    }

    #[Route(path:'/simple-subscription-discover', name: 'simple_subscription_discover')]
    public function simpleSubscriptionDiscover() : Response
    {
        return $this->render('screens/simple_subscription_discorver.html.twig');
    }
}
