<?php

namespace AppBundle\Security;

use AppBundle\Form\LoginForm;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class LdapGuardAuthenticator extends AbstractFormLoginAuthenticator
{
    /** @var \AppBundle\Ldap\LdapUserProvider $ldapUserProvider */
    private $ldapUserProvider;

    private $formFactory;

    public function __construct(\AppBundle\Ldap\LdapUserProvider $ldapUserProvider, FormFactory $formFactory)
    {
        $this->ldapUserProvider = $ldapUserProvider;
        $this->formFactory = $formFactory;
    }

    /**
     * Return the URL to the login page.
     * @return string
     */
    protected function getLoginUrl()
    {
        return '/login';
    }

    /**
     * Get the authentication credentials from the request and return them
     * as any type (e.g. an associate array). If you return null, authentication
     * will be skipped.
     *
     * @param Request $request
     *
     * @return mixed|null
     */
    public function getCredentials(Request $request)
    {
        if(!$request->isMethod(Request::METHOD_POST)) {
            return null;
        }

        $form = $this->formFactory->create(LoginForm::class);
        $form->handleRequest($request);
        dump($form);
        dump($form->getData());
        return $form->getData();
    }

    /**
     * Return a UserInterface object based on the credentials.
     *
     * The *credentials* are the return value from getCredentials()
     *
     * You may throw an AuthenticationException if you wish. If you return
     * null, then a UsernameNotFoundException is thrown for you.
     *
     * @param mixed $credentials
     * @param UserProviderInterface $userProvider
     *
     * @throws AuthenticationException
     *
     * @return UserInterface|null
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
//        $ldapProvider = new LdapUserProvider(
//            $ldapClient,
//            'dc=biig,dc=local',
//            'cn=admin,dc=biig,dc=local',
//            'to4rhTw@rzT8',
//            ['ROLE_EMPLOYE'],
//            'uid'
//        );
//        $user = $ldapProvider->loadUserByUsername($credentials['username']);
dump($credentials);
        $user = $this->ldapUserProvider->findByUsernameAndPassword($credentials['username'], $credentials['password']);
        dump($user);
        return $user;
    }

    /**
     * Returns true if the credentials are valid.
     *
     * If any value other than true is returned, authentication will
     * fail. You may also throw an AuthenticationException if you wish
     * to cause authentication to fail.
     *
     * The *credentials* are the return value from getCredentials()
     *
     * @param mixed $credentials
     * @param UserInterface $user
     *
     * @return bool
     *
     * @throws AuthenticationException
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        // TODO: Implement checkCredentials() method.
    }
}