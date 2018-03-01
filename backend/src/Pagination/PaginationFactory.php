<?php

namespace App\Pagination;

use Pagerfanta\Adapter\ArrayAdapter;
use Symfony\Component\HttpFoundation\Request;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\Routing\RouterInterface;

class PaginationFactory
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * PaginationFactory constructor.
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder| array $qb
     * @param Request $request
     * @param $route
     * @param array $routeParams
     * @return PaginatedCollection
     */
    public function createCollection($qb, Request $request, $route, array $routeParams = array())
    {
        $page = $request->query->get('page', 1);
        $perPage = $request->query->get('perpage', 10);

        if(is_array($qb)){
            $adapter = new ArrayAdapter($qb);
        }
        else{
            $adapter = new DoctrineORMAdapter($qb, true, false);
        }

        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($perPage);
        $pagerfanta->setCurrentPage($page);

        $items = [];

        foreach ($pagerfanta->getCurrentPageResults() as $result) {
            $items[] = $result;
        }

        // make sure query parameters are included in pagination links
        $routeParams = array_merge($routeParams, $request->query->all());

        $createLinkUrl = function ($targetPage) use ($route, $routeParams) {
            return rawurldecode($this->router->generate(
                $route,
                array_merge(
                    $routeParams,
                    array('page' => $targetPage)
                )
            ));
        };

        $paginatedCollection = new PaginatedCollection(
            $items,
            $pagerfanta->getNbResults(),
            $pagerfanta->getNbPages()
        );

        $paginatedCollection->addLink('self', $createLinkUrl($page));
        $paginatedCollection->addLink('first', $createLinkUrl(1));
        $paginatedCollection->addLink('last', $createLinkUrl($pagerfanta->getNbPages()));

        if ($pagerfanta->hasNextPage()) {
            $paginatedCollection->addLink('next', $createLinkUrl($pagerfanta->getNextPage()));
        }

        if ($pagerfanta->hasPreviousPage()) {
            $paginatedCollection->addLink('previous', $createLinkUrl($pagerfanta->getPreviousPage()));
        }

        return $paginatedCollection;
    }
}