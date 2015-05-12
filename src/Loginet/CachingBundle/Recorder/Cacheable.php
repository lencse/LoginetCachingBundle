<?php

namespace Loginet\CachingBundle\Recorder;


interface Cacheable
{

    /**
     * @return string
     */
    public function getCacheName();

    /**
     * @return string
     */
    public function getCacheId();

    /**
     * @return string
     */
    public function getCacheDataAsString();

}