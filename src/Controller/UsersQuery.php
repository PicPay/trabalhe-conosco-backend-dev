<?php
namespace App\Controller;


use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UsersQuery extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * UsersQuery constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(Request $request)
    {
        $query = $request->get('query');
        $page = $request->get('page', 1);

        if (empty($query) || empty($page)) {
            return $this->json([
                'error' => 'Query e page devem ser informados.',
            ], Response::HTTP_BAD_REQUEST);
        }

        return $this->json($this->userRepository->search($query, $page));

    }


}