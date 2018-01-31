<?php

namespace AppBundle\Controller;

use AppBundle\Security\LdapClient;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Ldap\Ldap;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\LdapUserProvider;

class LdapController extends Controller
{
    /**
     * @Route("/test", name="test")
     */
    public function indexAction(Request $request)
    {
        /** @var Ldap $ldapClient */
        $ldapClient = $this->get('app.ldap.client');

        $ldapProvider = new LdapUserProvider(
            $ldapClient,
            'dc=biig,dc=local',
            'cn=admin,dc=biig,dc=local',
            'to4rhTw@rzT8',
            ['ROLE_EMPLOYE'],
            'uid'
        );
        $geoffroy = $ldapProvider->loadUserByUsername('cornug');
        dump($geoffroy);

        return new JsonResponse('');
    }

    /**
     * @Route("/oauth/v2/auth/login_check", name="ldap_login_check")
     */
    public function loginCheckAction(Request $request)
    {
        dump($request);
        throw new \Exception('YOUPI');
        return new JsonResponse('');
    }

    /**
     * @Route("/login", name="ldap_login")
     */
    public function loginAction(Request $request)
    {
        dump($request);
        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        /** @var $session \Symfony\Component\HttpFoundation\Session\Session */
        $session = $request->getSession();

        $lastUsernameKey = Security::LAST_USERNAME;
        return $this->render('login.html.twig', [
            'csrf_token'    => $csrfToken,
            'last_username' => $session->get($lastUsernameKey)
        ]);
    }
}
