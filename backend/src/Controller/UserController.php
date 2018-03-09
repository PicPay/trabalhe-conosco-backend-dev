<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserPriority;
use App\Pagination\PaginationFactory;
use JMS\Serializer\SerializerBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserController
 * @package App\Controller
 *
 * @Route("/users", name="api_users_")
 * @Security("has_role('ROLE_USER')")
 */
class UserController extends AbstractController
{
    use ControllerTrait;

    /**
     * @var PaginationFactory
     */
    private $paginationFactory;

    /**
     * UserController constructor.
     * @param PaginationFactory $paginationFactory
     */
    public function __construct(PaginationFactory $paginationFactory)
    {
        $this->paginationFactory = $paginationFactory;
    }

    /**
     * @Route("/", name="collection")
     * @Method("GET")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $params = $request->query->all();

        $repository = $this->getDoctrine()->getRepository(User::class);
        $qb = $repository->findAllQueryBuilder($params);
        $paginatedCollection = $this->paginationFactory->createCollection(
            $qb,
            $request,
            'api_users_collection',
            [],
            false
        );

        $response = $this->createApiResponse($paginatedCollection, 200);
        return $response;
    }
}