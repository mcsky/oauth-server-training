<?php
namespace AppBundle\Ldap;


use Symfony\Component\Ldap\Exception\ConnectionException;
use Symfony\Component\Ldap\Ldap;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class LdapUserProvider extends AbstractLdapProvider
{
    const UID_KEY = 'uid';

    const QUERY_USERNAME = '(' . self::UID_KEY . '=%s)';
    const QUERY_USERNAME_AND_PASSWORD = '(uid=%s)';

    public function __construct(Ldap $ldap, $searchPassword)
    {
        parent::__construct($ldap, $searchPassword);
    }

    protected function getDn(): string
    {
        return parent::BASE_DN . '';
    }

    public function findByUsernameAndPassword(string $username, string $password, bool $enabled = true)
    {
        try {
            $this->bindDn($this->getDn());
            $search = $this->ldapClient->query(AbstractLdapProvider::BASE_DN, sprintf(self::QUERY_USERNAME, $username));
        } catch (ConnectionException $e) {
            dump($e);
            throw new UsernameNotFoundException(sprintf('User "%s" not found.', $username), 0, $e);
        }

        $entries = $search->execute();
        $count = count($entries);
        dump($entries);
        dump($count);
        if (!$count) {
            throw new UsernameNotFoundException(sprintf('User "%s" not found.', $username));
        }

        if ($count > 1) {
            throw new UsernameNotFoundException('More than one user found');
        }

        $entry = $entries[0];
        dump($entries);
//
//        try {
//            if (null !== $this->uidKey) {
//                $username = $this->getAttributeValue($entry, $this->uidKey);
//            }
//        } catch (InvalidArgumentException $e) {
//        }
    }
}