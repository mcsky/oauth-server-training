<?php
namespace AppBundle\Managers;

use FOS\OAuthServerBundle\Model\RefreshTokenManagerInterface;
use FOS\OAuthServerBundle\Entity\TokenManager;

class RefreshTokenManager extends TokenManager implements RefreshTokenManagerInterface
{
}
