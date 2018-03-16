<?php

namespace App\Controller;

use App\Entity\UserAuth;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserAuthController
 * @package App\Controller
 *
 * @Route("/users-auth", name="api_users_auth_")
 */
class UserAuthController extends AbstractController
{
    use ControllerTrait;

    /**
     * @Security("has_role('ROLE_USER')")
     * @Route("/{usernameOrEmail}", name="show")
     * @Method("GET")
     * @param Request $request
     * @param $usernameOrEmail
     * @return Response
     */
    public function show(Request $request, $usernameOrEmail)
    {
        $user = $this->getDoctrine()->getRepository(UserAuth::class)->findUser($usernameOrEmail);
        if (!$user) {
            throw $this->createNotFoundException(
                sprintf(
                    'No user found with param "%s"',
                    $usernameOrEmail
                )
            );
        }

        $response = $this->createApiResponse($user, 200);
        return $response;
    }
}