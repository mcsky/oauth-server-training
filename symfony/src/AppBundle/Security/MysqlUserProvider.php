<?php

namespace AppBundle\Security;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class MysqlUserProvider implements UserProviderInterface
{
    /** @var EntityManager $entityManager */
    private $entityManager;

    /** @var EntityRepository $userRepository */
    private $userRepository;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $this->entityManager->getRepository('AppBundle:User');
    }


    /**
     * Loads the user for the given username.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @param string $username The username
     *
     * @return UserInterface
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByUsername($username)
    {
        /** @var User $user */
        $user = $this->userRepository->findOneBy(['username' => $username]);

        if (!$user) {
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$this->supportsClass(get_class($user))) {
            throw new UnsupportedUserException(sprintf('Expected an instance of %s, but got "%s".', $this->userRepository->getClassName(), get_class($user)));
        }

        if (null === $reloadedUser = $this->userRepository->findOneBy(array('id' => $user->getId()))) {
            throw new UsernameNotFoundException(sprintf('User with ID "%s" could not be reloaded.', $user->getId()));
        }

        return $reloadedUser;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        $userClass = $this->userRepository->getClassName();

        return $userClass === $class || is_subclass_of($class, $userClass);
    }
}