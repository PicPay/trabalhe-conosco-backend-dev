<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class GetTokenAction
 * @package App\Controller
 */
class GetTokenAction extends Controller
{
    public function __invoke()
    {
        return $this->json([], 401);
    }


}