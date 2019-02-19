<?php

namespace App\Controller;

use App\Service\UserImporter;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UserController
 *
 * @package App\Controller
 * @Route("/user", name="user")
 */
class UserController extends AbstractController
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var UserImporter
     */
    protected $userImporter;

    /**
     * UserController constructor.
     *
     * @param UserRepository $userRepository
     * @param UserImporter $userImporter
     */
    public function __construct(UserRepository $userRepository, UserImporter $userImporter)
    {
        $this->userRepository = $userRepository;
        $this->userImporter = $userImporter;
    }

    /**
     * @Route("/import", name="_import")
     * @Method({"GET"})
     *
     * @return JsonResponse
     */
    public function import()
    {
        try {
            $this->userImporter->import();

            return $this->getSuccessJsonResponse(
                'Users imported.',
                JsonResponse::HTTP_CREATED
            );
        } catch (\Exception $e) {
            return $this->getErrorJsonResponse($e);
        }
    }

    /**
     * @Route("", name="_get_users")
     * @Method({"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getUsers(Request $request)
    {
        try {
            return new JsonResponse([
                'status' => 'success',
                'users' => $this->userRepository->findByFilter([
                    'name' => $request->get('name', ''),
                    'username' => $request->get('username', '')
                ],
                $request->get('page', 0),
                $request->get('size', 15)),
            ]);
        } catch (\Exception $e) {
            return $this->getErrorJsonResponse($e);
        }
    }
}