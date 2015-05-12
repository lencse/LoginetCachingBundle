<?php

namespace Loginet\CachingBundle\Cache;


interface CacheInterface
{
    /**
     * @return bool
     */
    public function isCached();

    /**
     * @return string
     */
    public function getValue();

    /**
     * @param $value
     */
    public function setValue($value);

    public function invalidate();

}