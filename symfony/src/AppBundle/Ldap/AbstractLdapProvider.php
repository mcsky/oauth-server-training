<?php
namespace AppBundle\Ldap;

use Symfony\Component\Ldap\Ldap;

abstract class AbstractLdapProvider
{
    const BASE_DN = 'dc=biig,dc=local';

    /** @var Ldap $ldapClient */
    protected $ldapClient;

    /** @var string $searchPassword */
    protected $searchPassword;

    public function __construct(Ldap $ldap, string $searchPassword)
    {
        $this->ldapClient = $ldap;
        $this->searchPassword = $searchPassword;
        $this->ldapClient->bind('cn=admin,dc=biig,dc=local', $searchPassword);
    }

    abstract protected function getDn(): string;

    protected function bindDn($childDn)
    {
        $this->ldapClient->bind(self::BASE_DN . ',' . $childDn, $this->searchPassword);
    }
}