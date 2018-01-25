<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\OAuthServerBundle\Model\ClientInterface;
use FOS\OAuthServerBundle\Util\Random;
use OAuth2\OAuth2;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 */
class Client implements ClientInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank()
     * @var string
     */
    protected $secret;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank()
     * @var string
     */
    protected $randomId;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank()
     * @var string
     */
    protected $name;

    /**
     * @Assert\DateTime()
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @Assert\DateTime()
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;

    /**
     * @var array
     * @Assert\NotBlank()
     * @ORM\Column(type="json_array")
     */
    protected $redirectUris;

    /**
     * @var array
     * @Assert\NotBlank()
     * @ORM\Column(type="json_array")
     */
    protected $allowedGrantTypes;

    public function __construct()
    {
        $this->allowedGrantTypes = [ OAuth2::GRANT_TYPE_AUTH_CODE ];
        $this->redirectUris = [];

        $this->setRandomId(Random::generateToken());
        $this->setSecret(Random::generateToken());
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setRandomId($random)
    {
        $this->randomId = $random;
    }

    /**
     * {@inheritdoc}
     */
    public function getRandomId(): string
    {
        return $this->randomId;
    }

    /**
     * {@inheritdoc}
     */
    public function getPublicId()
    {
        return sprintf('%s_%s', $this->getId(), $this->getRandomId());
    }

    /**
     * {@inheritdoc}
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;
    }

    /**
     * {@inheritdoc}
     */
    public function getSecret(): string
    {
        return $this->secret;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function checkSecret($secret)
    {
        return null === $this->secret || $secret === $this->secret;
    }

    public function setRedirectUris(array $redirectUris)
    {
        $this->redirectUris = $redirectUris;
    }

    public function getRedirectUris(): array
    {
        return $this->redirectUris;
    }

    public function setAllowedGrantTypes(array $grantTypes)
    {
        $this->allowedGrantTypes = $grantTypes;
    }

    public function getAllowedGrantTypes(): array
    {
        return $this->allowedGrantTypes;
    }
}
