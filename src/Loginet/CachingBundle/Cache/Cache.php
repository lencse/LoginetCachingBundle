<?php

namespace Loginet\CachingBundle\Cache;


use Assetic\Cache\CacheInterface as AsseticCacheInterface;
use Loginet\CachingBundle\Cache\Date\DateProviderInterface;
use Loginet\CachingBundle\Cache\Exception\CacheException;
use Loginet\CachingBundle\Cache\Exception\MissingCacheException;

class Cache implements CacheInterface
{

    const VALUE_KEY = 'value';
    const DATE_KEY = 'date';

    /**
     * @var AsseticCacheInterface
     */
    protected $cache;

    /**
     * @var DateProviderInterface
     */
    protected $dateProvider;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $id;

    /**
     * @param AsseticCacheInterface $cache
     * @param DateProviderInterface $dateProvider
     * @param $name string
     * @param $id string
     */
    function __construct(AsseticCacheInterface $cache, DateProviderInterface $dateProvider, $name, $id)
    {
        $this->cache = $cache;
        $this->dateProvider = $dateProvider;
        $this->name = $name;
        $this->id = $id;
    }

    /**
     * @return string
     * @throws CacheException
     */
    public function getValue()
    {
        $this->validateCache();

        return $this->cache->get($this->getKey(self::VALUE_KEY));
    }

    /**
     * @return bool
     */
    public function isCached()
    {
        return $this->isCacheSet();
    }

    /**
     * @param $value
     */
    public function setValue($value)
    {
        $this->cache->set($this->getKey(self::VALUE_KEY), $value);
        $this->cache->set($this->getKey(self::DATE_KEY), $this->dateProvider->now()->format('Y-m-d H:i:s'));
    }

    public function invalidate()
    {
        $this->cache->remove($this->getKey(self::VALUE_KEY));
        $this->cache->remove($this->getKey(self::DATE_KEY));
    }

    /**
     * @return bool
     */
    protected function isCacheSet()
    {
        return $this->cache->has($this->getKey(self::DATE_KEY)) && $this->cache->has($this->getKey(self::VALUE_KEY));
    }

    /**
     * @param $key string
     * @return string
     */
    protected function getKey($key)
    {
        return implode('.', [$this->name, $this->id, $key]);
    }

    /**
     * @throws CacheException
     */
    protected function validateCache()
    {
        if (!$this->isCacheSet()) {
            throw new MissingCacheException($this->name, $this->id);
        }
    }

}
