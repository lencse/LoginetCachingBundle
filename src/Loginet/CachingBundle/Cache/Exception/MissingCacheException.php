<?php

namespace Loginet\CachingBundle\Cache\Exception;


class MissingCacheException extends CacheException
{

    /**
     * @return string
     */
    protected function getMessageForInit()
    {
        return sprintf('Missing cache - name: "%s", id: "%s"', $this->name, $this->id);
    }

}
