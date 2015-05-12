<?php


namespace Loginet\CachingBundle\Tests\Recorder;


use Assetic\Cache\ArrayCache;
use Loginet\CachingBundle\Cache\Cache;
use Loginet\CachingBundle\Cache\ExpiringCache;
use Loginet\CachingBundle\Recorder\CacheRecorder;

class CacheRecorderTest extends CacheRecorderTestBase
{

    public function testNonExpireCache()
    {
        $data = new TestDataClass1($this->dateProvider);
        $cache = new Cache(new ArrayCache(), $this->dateProvider, $data->getCacheName(), $data->getCacheId());
        $recorder = new CacheRecorder($cache, $data);
        $this->runTestOnNonExpiringCacheRecorder($recorder);
    }

    public function testExpireCache()
    {
        $data = new TestDataClass2($this->dateProvider);
        $cache = new ExpiringCache(new ArrayCache(), $this->dateProvider, $data->getCacheName(), $data->getCacheId(), 3600);
        $recorder = new CacheRecorder($cache, $data);
        $this->runTestOnExpiringCacheRecorder($recorder);
    }

}
