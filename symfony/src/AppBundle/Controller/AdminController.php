<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class AdminController extends Controller
{
    /**
     * @Route("/client", name="create_client")
     * @Method("POST")
     */
    public function createClientAction(Request $request)
    {
//        /** @var Client $clientBuilder */
//        $clientBuilder = $this->get(Client::class);
//        $newClient = $clientBuilder->create([], []);

        return $this->json([]);
    }
}
