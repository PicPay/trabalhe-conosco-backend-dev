<?php

namespace App\Controller;

set_time_limit(0);

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
            $criteria = [
                'name' => $request->get('name', ''),
                'username' => $request->get('username', '')
            ];

            if($request->get('sort', '0') === '0') {
                $sort = ['user.priority' => 'ASC'];
            }
            else {
                $sort = ['user.priority' => 'ASC', 'user.name' => 'ASC'];
            }

            $start = new \DateTime();
            $users = $this->userRepository->findByFilter(
                $criteria,
                $sort,
                $request->get('page', 0),
                $request->get('size', 15)
            );
            $end = new \DateTime();
            $interval = \date_diff($end, $start);

            return new JsonResponse([
                'status' => 'success',
                'time' => $interval->format("%H:%I:%S"),
                'users' => $users,
                'totalUsers' => $this->userRepository->countByFilter($criteria),
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
            if($request->get('sort', '0') === '0') {
                $sort[] = ['priority' => 'asc'];
            }
            else {
                $sort[] = ['priority' => 'asc', 'name' => 'asc'];
            }

            $start = new \DateTime();
            $users = $this->elasticUserManager->query([
                'criteria' => $criteria,
                'page' => $request->get('page', 0),
                'size' => $request->get('size', 15),
                'sort' => $sort
            ]);
            $end = new \DateTime();
            $interval = \date_diff($end, $start);

            return new JsonResponse([
                'status' => 'success',
                'time' => $interval->format("%H:%I:%S"),
                'users' => $users,
                'totalUsers' => $this->elasticUserManager->count(['criteria' => $criteria]),
            ]);
        } catch (\Exception $e) {
            return $this->getErrorJsonResponse($e);
        }
    }
}
