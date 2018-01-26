<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class LdapController extends Controller
{
    /**
     * @Route("/oauth/v2/auth/ldap_login_check", name="ldap_login_check")
     */
    public function indexAction(Request $request)
    {
        dump($request);
        // replace this example code with whatever you need
        return new JsonResponse();
    }
}
