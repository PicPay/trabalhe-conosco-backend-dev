<?php

namespace App\Controller;

use App\Entity\UserAuth;
use App\Pagination\PaginationFactory;
use Roromix\Bundle\SpreadsheetBundle\Factory;
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
     * @Security("has_role('ROLE_USER')")
     * @Route("/", name="collection")
     * @Method("GET")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $params = $request->query->all();
        $qb = $this->getDoctrine()->getRepository(UserAuth::class)->findAllQueryBuilder($params);
        $paginatedCollection = $this->paginationFactory->createCollection($qb, $request, 'api_users_collection');
        $response = $this->createApiResponse($paginatedCollection, 200);

        return $response;
    }
}