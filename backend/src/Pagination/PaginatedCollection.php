<?php

namespace App\Pagination;

use App\Annotation\Link;
use JMS\Serializer\Annotation as Serializer;

/**
 * @Link(
 *     "self",
 *     url = "object.getUrl('self')"
 * )
 *
 * @Link(
 *     "first",
 *     url = "object.getUrl('first')"
 * )
 *
 * @Link(
 *     "last",
 *     url = "object.getUrl('last')"
 * )
 *
 * @Link(
 *     "next",
 *     url = "object.getUrl('next')"
 * )
 *
 * @Link(
 *     "previous",
 *     url = "object.getUrl('previous')"
 * )
 *
 * @Serializer\ExclusionPolicy("all")
 */
class PaginatedCollection
{

    /**
     * @Serializer\Expose()
     *
     * @var
     */
    private $items;

    /**
     * @Serializer\Expose()
     *
     * @var
     */
    private $total;

    /**
     * @Serializer\Expose()
     *
     * @var
     */
    private $count;

    /**
     * @Serializer\Expose()
     *
     * @var
     */
    private $nbPages;

    /**
     * @var array
     */
    private $_links = array();

    /**
     * PaginatedCollection constructor.
     * @param $items
     * @param $total
     * @param $nbPages
     */
    public function __construct($items, $total, $nbPages)
    {
        $this->items = $items;
        $this->total = $total;
        $this->count = count($items);
        $this->nbPages = $nbPages;
    }

    public function addLink($ref, $url)
    {
        $this->_links[$ref] = $url;
    }

    public function getUrl($ref)
    {
        return isset($this->_links[$ref]) ? $this->_links[$ref] : '';
    }

    public function getItems()
    {
        return $this->items;
    }

    public function setItems($items)
    {
        $this->items = $items;
    }
}