<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class HomeAction
 * @package App\Controller
 */
class HomeAction extends Controller
{
    public function __invoke()
    {
        return $this->render('index.html.twig');
    }

}