<?php

namespace AppBundle\Security;

use Symfony\Component\Ldap\Ldap;

class LdapClient
{
    private $ldapInstance;

    public function __construct(string $host)
    {
        $ldap = Ldap::create('ext_ldap', [
            'host' => $host,
        ]);

        $this->ldapInstance = $ldap;
    }

    public function getInstance()
    {
        return $this->ldapInstance;
    }
}