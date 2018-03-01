<?php

namespace App\Serializer;

use App\Annotation\Link;
use Doctrine\Common\Annotations\Reader;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use JMS\Serializer\JsonSerializationVisitor;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\Routing\RouterInterface;

class LinkSerializationSubscriber implements EventSubscriberInterface
{
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var Reader
     */
    private $annotationReader;
    /**
     * @var ExpressionLanguage
     */
    private $expressionLanguage;

    public function __construct(RouterInterface $router, Reader $annotationReader)
    {
        $this->router = $router;
        $this->annotationReader = $annotationReader;
        $this->expressionLanguage = new ExpressionLanguage();
    }

    public static function getSubscribedEvents()
    {
        return array(
            array(
                'event' => 'serializer.post_serialize',
                'method' => 'onPostSerialize',
                'format' => 'json',
            )
        );
    }

    public function onPostSerialize(ObjectEvent $event)
    {
        $object = $event->getObject();
        /** @var JsonSerializationVisitor $visitor */
        $visitor = $event->getVisitor();
        $annotations = $this->annotationReader->getClassAnnotations(new \ReflectionClass($object));
        $links = array();
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Link) {
                if ($annotation->url) {
                    $uri = $this->evaluate($annotation->url, $object);
                } else {
                    $uri = $this->router->generate(
                        $annotation->route,
                        $this->resolveParams($annotation->params, $object)
                    );
                }
                if ($uri) {
                    $links[$annotation->name] = $uri;
                }
            }
        }
        if ($links) {
            $visitor->setData('_links', $links);
        }
    }

    private function resolveParams(array $params, $object)
    {
        foreach ($params as $key => $param) {
            $params[$key] = $this->evaluate($param, $object);
        }
        return $params;
    }

    private function evaluate($expression, $object)
    {
        return $this->expressionLanguage
            ->evaluate($expression, array('object' => $object));
    }
}