<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Client;
use AppBundle\Entity\User;
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
                'http://localhost:4000/callback.php'
            ]);
            $client->setAllowedGrantTypes([
               OAuth2::GRANT_TYPE_AUTH_CODE,
               OAuth2::GRANT_TYPE_REFRESH_TOKEN,
            ]);
            $client->setName('Client de test N°' . $i);
            $manager->persist($client);
        }

        $user = new User();
        $user->setEmail('toto@biig.fr');
        $user->setRoles('ROLE_EMPLOYE');
        $user->setAvatarUrl('http://pre14.deviantart.net/dd01/th/pre/i/2008/096/c/1/darth_vader_by_hellself3003.jpg');
        $user->setDateCreation(new \DateTime('-1 month'));
        $user->setDateLastConnection(new \DateTime());
        $user->setLastName('Labricot');
        $user->setFirstName('Toto');


        $user->setUsername('toto');
        $user->setPassword('abricot');
        $manager->persist($user);

        $manager->flush();
    }
}