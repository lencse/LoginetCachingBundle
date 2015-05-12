<?php


namespace Loginet\CachingBundle\Recorder;


use Loginet\CachingBundle\Cache\Cache;
use Loginet\CachingBundle\Cache\Date\DateProviderInterface;
use Assetic\Cache\CacheInterface as AsseticCacheInterface;
use Loginet\CachingBundle\Cache\ExpiringCache;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CacheRecorderFactory
{

    /**
     * @var DateProviderInterface
     */
    private $dateProvider;

    /**
     * @var AsseticCacheInterface
     */
    private $cache;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param AsseticCacheInterface $cache
     * @param ContainerInterface $container
     * @param DateProviderInterface $dateProvider
     */
    function __construct(AsseticCacheInterface $cache, ContainerInterface $container, DateProviderInterface $dateProvider)
    {
        $this->dateProvider = $dateProvider;
        $this->cache = $cache;
        $this->container = $container;
    }

    /**
     * @param Cacheable $data
     * @return CacheRecorder
     */
    public function createCacheRecorder(Cacheable $data)
    {
        $configVal = trim($this->container->getParameter('loginet_caching.expiration_second.' . $data->getCacheName()));
        if ($configVal == 'none') {
            $cache = new Cache($this->cache, $this->dateProvider, $data->getCacheName(), $data->getCacheId());
        }
        else {
            $cache =  new ExpiringCache($this->cache, $this->dateProvider, $data->getCacheName(), $data->getCacheId(), (int) $configVal);
        }

        return new CacheRecorder($cache, $data);
    }

}