<?php

namespace App\Controller;

use App\Service\UserImporter;
use App\Service\Elastic\UserImporter as ElasticUserImporter;
use App\Service\Elastic\UserManager as ElasticUserManager;
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
     * @var ElasticUserImporter
     */
    protected $elasticUserImporter;

    /**
     * @var ElasticUserManager
     */
    protected $elasticUserManager;

    /**
     * UserController constructor.
     *
     * @param UserRepository $userRepository
     * @param UserImporter $userImporter
     * @param ElasticUserImporter $elasticUserImporter
     * @param ElasticUserManager $elasticUserManager
     */
    public function __construct(UserRepository $userRepository, UserImporter $userImporter, ElasticUserImporter $elasticUserImporter, ElasticUserManager $elasticUserManager)
    {
        $this->userRepository = $userRepository;
        $this->userImporter = $userImporter;
        $this->elasticUserImporter = $elasticUserImporter;
        $this->elasticUserManager = $elasticUserManager;
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
     * @Route("/es/reset", name="_elastic_reset")
     * @Method({"GET"})
     *
     * @return JsonResponse
     */
    public function resetElastic()
    {
        try {
            $this->elasticUserManager->reset();

            return $this->getSuccessJsonResponse(
                'Users Elasticsearch database reseted.',
                JsonResponse::HTTP_CREATED
            );
        } catch (\Exception $e) {
            return $this->getErrorJsonResponse($e);
        }
    }

    /**
     * @Route("/es/import", name="_elastic_import")
     * @Method({"GET"})
     *
     * @return JsonResponse
     */
    public function importElastic()
    {
        try {
            $this->elasticUserImporter->import();

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

    /**
     * @Route("/es", name="_elastic_get_users")
     * @Method({"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getUsersElastic(Request $request)
    {
        try {
            $criteria = [];
            $name = $request->get('name', '');
            if($name !== '') {
                $criteria[] = ['wildcard' => ['name' => '*'.$name.'*']];
            }
            $username = $request->get('username', '');
            if($username !== '') {
                $criteria[] = ['wildcard' => ['username' => '*'.$username.'*']];
            }

            $sort = [];
            $sort[] = ['priority' => 'asc', 'name' => 'asc'];
            return new JsonResponse([
                'status' => 'success',
                'users' => $this->elasticUserManager->query([
                    'criteria' => $criteria,
                    'page' => $request->get('page', 0),
                    'size' => $request->get('size', 15),
                    'sort' => $sort
                ])
            ]);
        } catch (\Exception $e) {
            return $this->getErrorJsonResponse($e);
        }
    }
}