<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    protected $firstName;

    /**
     * @Assert\NotBlank()

     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $lastName;

    /**
     * @ORM\Column(type="string", length=512)
     */
    protected $avatarUrl;

    /**
     * @ORM\Column(type="string", length=512)
     * @Assert\NotBlank()
     */
    protected $password;

    /**
     * @ORM\Column(type="string", length=512)
     * @Assert\NotBlank()
     */
    protected $email;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $dateCreation;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank()
     */
    protected $salt;

    /**
     * @ORM\Column(type="string", length=128)
     * @Assert\NotBlank()
     */
    protected $username;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $dateLastConnection;

    /**
     * @ORM\Column(type="string")
     */
    protected $roles = 'ROLE_USER';

    public function __construct()
    {
        $fp = fopen('/dev/urandom', 'r');
        $randomString = base64_encode(fread($fp, 16));
        fclose($fp);
        $this->salt = $randomString;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        return;
    }
}