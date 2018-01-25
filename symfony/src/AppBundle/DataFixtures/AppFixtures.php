<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use OAuth2\OAuth2;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 5; $i++) {
            $client = new Client();
            $client->setRedirectUris([
                '/oauth/mycallbackurl'
            ]);
            $client->setAllowedGrantTypes([
               OAuth2::GRANT_TYPE_AUTH_CODE,
               OAuth2::GRANT_TYPE_REFRESH_TOKEN,
            ]);
            $client->setName('Client de test N°' . $i);
            $manager->persist($client);
        }

        $manager->flush();
    }
}