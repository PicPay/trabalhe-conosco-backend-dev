<?php

namespace App\Pagination;

use Doctrine\DBAL\Query\QueryBuilder;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Adapter\DoctrineDbalAdapter;
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
     * @param $qb
     * @param Request $request
     * @param $route
     * @param array $routeParams
     * @param bool $fetchJoinCollection
     * @param null $countQueryBuilderModifier
     * @return PaginatedCollection
     */
    public function createCollection($qb, Request $request, $route, array $routeParams = array(), $fetchJoinCollection = true, $countQueryBuilderModifier = null)
    {
        $page = $request->query->get('page', 1);
        $perPage = $request->query->get('perpage', 10);

        if($qb instanceof QueryBuilder){
            $adapter = new DoctrineDbalAdapter($qb, $countQueryBuilderModifier);
        }
        else{
            $adapter = new DoctrineORMAdapter($qb, $fetchJoinCollection, false);
        }

        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($perPage);
        $pagerfanta->setCurrentPage($page);

        $items = [];

        foreach ($pagerfanta->getCurrentPageResults() as $result) {
            $items[] = $result;
        }

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