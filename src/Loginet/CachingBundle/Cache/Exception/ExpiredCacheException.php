<?php

namespace Loginet\CachingBundle\Cache\Exception;


class ExpiredCacheException extends CacheException
{

    /**
     * @return string
     */
    protected function getMessageForInit()
    {
        return sprintf('Expired cache - name: "%s", id: "%s"', $this->name, $this->id);
    }

}
