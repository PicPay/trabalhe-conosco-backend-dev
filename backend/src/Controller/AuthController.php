<?php

namespace App\Controller;

use App\Entity\UserAuth;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

/**
 * Class AuthController
 * @package App\Controller
 *
 * @Route("/auth", name="api_auth_")
 */
class AuthController extends AbstractController
{
    use ControllerTrait;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;
    /**
     * @var JWTEncoderInterface
     */
    private $defaultEncoder;

    /**
     * AuthController constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param JWTEncoderInterface $defaultEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder, JWTEncoderInterface $defaultEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->defaultEncoder = $defaultEncoder;
    }

    /**
     * @Route("/signin", name="signin")
     * @Method("POST")
     * @param Request $request
     * @return JsonResponse
     * @throws JWTEncodeFailureException
     */
    public function signInAction(Request $request)
    {
        $user = $this->getDoctrine()->getRepository(UserAuth::class)->findUser($request->getUser());
        if (!$user) {
            throw $this->createNotFoundException();
        }

        $isValid = $this->passwordEncoder->isPasswordValid($user, $request->getPassword());
        if (!$isValid) {
            throw new BadCredentialsException();
        }

        $user->setLastLoginAt(new \DateTime());
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $userSerialized = $this->serialize($user);

        $token = $this->defaultEncoder->encode(
            [
                'user' => json_decode($userSerialized),
                //'exp' => time() + 993600
                'exp' => time() + 3600 // 1 hour expiration
            ]
        );

        return new JsonResponse(['token' => $token]);
    }
}