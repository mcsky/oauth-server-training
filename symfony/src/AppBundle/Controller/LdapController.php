<?php

namespace AppBundle\Controller;

use AppBundle\Form\LoginForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Ldap\Ldap;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\LdapUserProvider;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

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
        $kevin = $ldapProvider->loadUserByUsername('cornug');

        return new JsonResponse('');
    }

    /**
     * @Route("/login", name="ldap_login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authUtils)
    {
        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        $form = $this->createForm(LoginForm::class);

        return $this->render('login.html.twig', [
            'error'    => $error,
            'form'          => $form->createView(),
            'last_username' => $lastUsername,
            'action' => '/oauth/v2/auth/test'
        ]);
    }
}
