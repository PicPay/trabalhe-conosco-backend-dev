<?php

namespace App\Annotation;
use Doctrine\Common\Annotations\Annotation\Required;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * @Annotation
 * @Target("CLASS")
 */
class Link
{
    /**
     * @Required()
     *
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $route;

    /**
     * @var array
     */
    public $params = array();

    /**
     * @var string
     */
    public $url;
}