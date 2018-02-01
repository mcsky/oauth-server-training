<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ApiController extends Controller
{
    /**
     * @Route("/api/default_scope", name="api_default_scope")
     * @Method("GET")
     */
    public function defaultScopeAction()
    {
        $this->denyAccessUnlessGranted('ROLE_DEFAULT');

        /** @var User $user */
        $user = $this->getUser();
        return $this->json([
            'username' => $user->getUsername(),
            'roles' => $user->getRoles(),
            'email' => $user->getEmail(),
        ]);
    }

    /**
     * @Route("/api/personal_informations", name="api_personal_informations_scope")
     * @Method("GET")
     */
    public function personalInformationsScopeAction()
    {
        $this->denyAccessUnlessGranted('ROLE_PERSONAL_INFORMATIONS');

        /** @var User $user */
        $user = $this->getUser();
        $dateFormat = 'Y-m-d H:i:s';
        return $this->json([
            'username' => $user->getUsername(),
            'roles' => $user->getRoles(),
            'dateCreation' => $user->getDateCreation()->format($dateFormat),
            'dateLastConnection' => $user->getDateLastConnection()->format($dateFormat),
            'avatarUrl' => $user->getAvatarUrl(),
            'email' => $user->getEmail(),
        ]);
    }
}
