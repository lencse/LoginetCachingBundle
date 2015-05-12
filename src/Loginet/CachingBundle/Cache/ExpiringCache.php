<?php

namespace Loginet\CachingBundle\Cache;


use Assetic\Cache\CacheInterface as AsseticCacheInterface;
use Doctrine\DBAL\Cache\CacheException;
use Loginet\CachingBundle\Cache\Date\DateProviderInterface;
use Loginet\CachingBundle\Cache\Exception\ExpiredCacheException;

class ExpiringCache extends Cache
{

    /**
     * @var int
     */
    private $expirationInSeconds;

    /**
     * @param AsseticCacheInterface $cache
     * @param DateProviderInterface $dateProvider
     * @param string $name
     * @param string $id
     * @param $expirationInSeconds
     */
    function __construct(AsseticCacheInterface $cache, DateProviderInterface $dateProvider, $name, $id, $expirationInSeconds)
    {
        $this->expirationInSeconds = $expirationInSeconds;
        parent::__construct($cache, $dateProvider, $name, $id);
    }

    /**
     * @throws CacheException
     */
    protected function validateCache()
    {
        parent::validateCache();
        if ($this->isExpired()) {
            throw new ExpiredCacheException($this->name, $this->id);
        }
    }

    /**
     * @return bool
     */
    public function isCached()
    {
        return parent::isCached() && !$this->isExpired();
    }

    private function isExpired()
    {
        $cachedOn = new \DateTime($this->cache->get($this->getKey(self::DATE_KEY)));
        $now = $this->dateProvider->now();
        $diff = $now->getTimestamp() - $cachedOn->getTimestamp();

        return $diff >= $this->expirationInSeconds;
    }

}