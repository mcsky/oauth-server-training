<?php

namespace AppBundle\Managers;

use FOS\OAuthServerBundle\Entity\TokenManager;
use FOS\OAuthServerBundle\Model\AccessTokenManagerInterface;

class AccessTokenManager extends TokenManager implements AccessTokenManagerInterface
{

}
