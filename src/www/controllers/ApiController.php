<?php

namespace MyApp\controllers;

use Psr\Container\ContainerInterface;
use Xandros15\SlimPagination\Pagination;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class ApiController
{
    protected $container;

   // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getUsers(Request $request, Response $response, array $args)
    {
        $per_page = $this->container['settings']['api']['pagination']['per_page'];
        $q = $request->getQueryParam('q');
        $page = $request->getQueryParam('page') ? $request->getQueryParam('page') : '1';
        $users = array("per_page" => $per_page, "total_results" => 0, "total_pages" => 0,"page" => $page, "results" => array());
        if (isset($q)) {
            $q = implode(" +", explode(" ", $request->getQueryParam('q')));
            $query = sprintf(
                "SELECT 
                u.*
                FROM users u
                LEFT JOIN users_relevance ur
                ON ur.id = u.id
                WHERE
                MATCH (name,username) AGAINST ('+%s' IN BOOLEAN MODE)
                ORDER BY ur.relevance desc,u.id",
                $q
            );

            $query_count = sprintf("SELECT count(0) total FROM (%s) tmp", $query);
            $queryObj = $this->container['db']->prepare($query_count);
            $queryObj->execute();
            $total = $queryObj->fetchAll();
            $users["per_page"] = $per_page;
            $users["total_results"] = $total[0]["total"] ;
            $users["total_pages"] = ceil($total[0]["total"] / $per_page);

            $start = $page - 1;
            $start = $start * $per_page;
            $query_results = sprintf("%s LIMIT %s,%s", $query, $start, $per_page);
            $queryObj = $this->container['db']->prepare($query_results);
            $queryObj->execute();
            $users["results"] = $queryObj->fetchAll();
        }

        return $response->withJson($users, 200)->withHeader('Content-type', 'application/json');
    }

    public function getUser(Request $request, Response $response, array $args)
    {
        $queryObj = $this->container['db']->prepare("SELECT * FROM users WHERE id=:id");
        $queryObj->bindParam("id", $args['id']);
        $queryObj->execute();
        $users = $queryObj->fetchObject();
        return $response->withJson($users, 200)->withHeader('Content-type', 'application/json');
    }
}
