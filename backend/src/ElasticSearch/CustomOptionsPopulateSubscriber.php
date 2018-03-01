<?php

namespace App\ElasticSearch;

use FOS\ElasticaBundle\Persister\Event\Events;
use FOS\ElasticaBundle\Persister\Event\PrePersistEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CustomOptionsPopulateSubscriber implements EventSubscriberInterface
{
    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [Events::PRE_PERSIST => 'onPrePersist'];
    }

    public function onPrePersist(PrePersistEvent $event)
    {
        $options = $event->getOptions();
        $options['reply_receive_timeout'] = 3600;
        $options['limit_overall_reply_time'] = 3600;

        $event->setOptions($options);
    }

}