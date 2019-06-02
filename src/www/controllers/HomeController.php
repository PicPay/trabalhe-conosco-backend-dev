<?php

namespace MyApp\controllers;

use Psr\Container\ContainerInterface;
use Xandros15\SlimPagination\Pagination;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class HomeController
{
    protected $container;

   // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function home(Request $request, Response $response, array $args)
    {
        $q = $request->getQueryParam('q');
        $page = $request->getQueryParam('page');
        $results = "";
        $pagination = false;
        if (isset($q)) {
            $service_url = sprintf('http://localhost/api/users?q=%s&page=%s', urlencode($q), urlencode($page));
            $curl = curl_init($service_url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $username = $this->container['settings']['api']['authentication']['user'];
            $password = $this->container['settings']['api']['authentication']['password'];
            curl_setopt($curl, CURLOPT_USERPWD, $username . ":" . $password);
            $curl_response = curl_exec($curl);
            curl_close($curl);
            $results = json_decode($curl_response);

            $pagination = new Pagination($request, $this->container->get('router'), [
            Pagination::OPT_TOTAL => $results->total_results ? $results->total_results : 1,
            Pagination::OPT_PER_PAGE => $results->per_page //number of items
            ]);
        }

        return $this->container['view']->render($response, 'index.twig', [
          'q' => $q,
          'users' => $results,
          'pagination' => $pagination
        ]);
    }
}
