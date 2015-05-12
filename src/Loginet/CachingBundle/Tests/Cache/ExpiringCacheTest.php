<?php


namespace Loginet\CachingBundle\Tests\Cache;


use Loginet\CachingBundle\Cache\CacheInterface;
use Loginet\CachingBundle\Cache\Exception\ExpiredCacheException;
use Loginet\CachingBundle\Cache\ExpiringCache;

class ExpiringCacheTest extends CacheTestBase
{

    public function testSetAndGet()
    {
        $cache = $this->getCache();
        $this->dateProvider->set(new \DateTime('2015-01-01 00:00:00'));
        $cache->setValue(self::TEST_VALUE);
        $this->dateProvider->set(new \DateTime('2015-01-01 00:59:00'));
        $this->assertEquals(self::TEST_VALUE, $cache->getValue());
    }

    public function testExpiration()
    {
        $cache = $this->getCache();
        $this->dateProvider->set(new \DateTime('2015-01-01 00:00:00'));
        $cache->setValue(self::TEST_VALUE);
        $this->dateProvider->set(new \DateTime('2015-01-01 01:01:00'));
        try {
            $val = $cache->getValue();
        }
        catch (ExpiredCacheException $e) {
            return;
        }
        $this->fail("Expired cache exception not thrown.");
    }

    public function testIsCachedAfterExpiration()
    {
        $cache = $this->getCache();
        $this->dateProvider->set(new \DateTime('2015-01-01 00:00:00'));
        $cache->setValue(self::TEST_VALUE);
        $this->dateProvider->set(new \DateTime('2015-01-01 01:01:00'));
        $this->assertFalse($cache->isCached());
    }

    /**
     * @param null $id
     * @return CacheInterface
     */
    protected function getCache($id = null)
    {
        return new ExpiringCache($this->arrayCache, $this->dateProvider, self::TEST_NAME, $id, 3600);
    }

}
