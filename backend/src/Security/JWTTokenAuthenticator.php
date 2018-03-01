<?php

namespace App\Security;

use App\Api\ApiProblem;
use App\Api\ResponseFactory;
use App\Entity\UserAuth;
use Doctrine\ORM\EntityManagerInterface;
use http\Exception\UnexpectedValueException;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\AuthorizationHeaderTokenExtractor;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\TokenExtractorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class JWTTokenAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * @var JWTEncoderInterface
     */
    private $jwtEncoder;

    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var TokenExtractorInterface
     */
    private $tokenExtractor;

    /**
     * jwtTokenAuthenticator constructor.
     * @param JWTEncoderInterface $jwtEncoder
     * @param ResponseFactory $responseFactory
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        JWTEncoderInterface $jwtEncoder,
        ResponseFactory $responseFactory,
        EntityManagerInterface $entityManager
    )
    {
        $this->jwtEncoder = $jwtEncoder;
        $this->responseFactory = $responseFactory;
        $this->entityManager = $entityManager;
        $this->tokenExtractor = new AuthorizationHeaderTokenExtractor('Bearer', 'Authorization');
    }


    /**
     *
     * @param Request $request The request that resulted in an AuthenticationException
     * @param AuthenticationException $authException The exception that started the authentication process
     *
     * @return Response
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $apiProblem = new ApiProblem(401);

        $message = $authException ? $authException->getMessageKey() : 'missing credentials';

        $apiProblem->set('detail', $message);

        return $this->responseFactory->createResponse($apiProblem);
    }

    /**
     * Does the authenticator support the given Request?
     *
     * If this returns false, the authenticator will be skipped.
     *
     * @param Request $request
     *
     * @return bool
     */
    public function supports(Request $request)
    {
        return false !== $this->tokenExtractor->extract($request);
    }

    /**
     *
     * @param Request $request
     *
     * @return mixed Any non-null value
     *
     * @throws UnexpectedValueException If null is returned
     */
    public function getCredentials(Request $request)
    {
        $token = $this->tokenExtractor->extract($request);
        if (!$token) {
            return null;
        }
        return $token;
    }

    /**
     *
     * @param mixed $credentials
     * @param UserProviderInterface $userProvider
     *
     * @throws AuthenticationException
     *
     * @return mixed
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        try {
            $data = $this->jwtEncoder->decode($credentials);
        } catch (JWTDecodeFailureException $e) {
            throw new CustomUserMessageAuthenticationException($e->getReason());
        }

        $email = $data['user']['email'];
        $user = $this->entityManager->getRepository(UserAuth::class)->findUser($email);

        if (is_null($user)) {
            Throw new CustomUserMessageAuthenticationException('User not found!');
        }

        return $user;
    }

    /**
     *
     * @param mixed $credentials
     * @param UserInterface $user
     *
     * @return bool
     *
     * @throws AuthenticationException
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    /**
     *
     * @param Request $request
     * @param AuthenticationException $exception
     *
     * @return Response|null
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $apiProblem = new ApiProblem(401);
        $apiProblem->set('detail', $exception->getMessageKey());
        return $this->responseFactory->createResponse($apiProblem);
    }

    /**
     *
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey The provider (i.e. firewall) key
     *
     * @return mixed
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // TODO: Implement onAuthenticationSuccess() method.
    }

    /**
     *
     * @return bool
     */
    public function supportsRememberMe()
    {
        return false;
    }
}