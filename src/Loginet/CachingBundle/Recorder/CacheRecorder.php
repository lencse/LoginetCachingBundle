<?php

namespace Loginet\CachingBundle\Recorder;


use Loginet\CachingBundle\Cache\CacheInterface;

class CacheRecorder
{

    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * @var Cacheable
     */
    private $data;

    /**
     * @param CacheFactory $cacheFactory
     * @param Cacheable $data
     */
    function __construct(CacheInterface $cache, Cacheable $data)
    {
        $this->cache = $cache;
        $this->data = $data;
    }

    /**
     * Reads the data from cache if presents, or generate it and save in cache
     *
     * @return string
     */
    public function readValue()
    {
        if ($this->cache->isCached()) {
            return $this->cache->getValue();
        }
        $ret = $this->data->getCacheDataAsString();
        $this->cache->setValue($ret);

        return $ret;
    }

    public function invalidate()
    {
        $this->cache->invalidate();
    }

}