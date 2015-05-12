<?php


namespace Loginet\CachingBundle\Tests\Cache;


use Loginet\CachingBundle\Cache\Cache;
use Loginet\CachingBundle\Cache\Exception\MissingCacheException;

class CacheTest extends CacheTestBase
{

    public function testSetAndGet()
    {
        $cache = $this->getCache();
        $cache->setValue(self::TEST_VALUE);
        $this->assertEquals(self::TEST_VALUE, $cache->getValue());
    }

    public function testIsCached()
    {
        $cache = $this->getCache();
        $this->assertFalse($cache->isCached());
        $cache->setValue(self::TEST_VALUE);
        $this->assertTrue($cache->isCached());
    }

    public function testInvalidate()
    {
        $cache = $this->getCache();
        $cache->setValue(self::TEST_VALUE);
        $cache->invalidate();
        $this->assertFalse($cache->isCached());
    }

    public function testExceptionWhenCacheIsNotSet()
    {
        try {
            $val = $this->getCache()->getValue();
        }
        catch (MissingCacheException $e) {
            return;
        }
        $this->fail("Missing cache exception not thrown.");
    }

    public function testValueForDifferentKeys()
    {
        $cache1 = $this->getCache(1);
        $cache2 = $this->getCache(2);
        $cache1->setValue('test1');
        $cache2->setValue('test2');
        $this->assertNotEquals($cache1->getValue(), $cache2->getValue());
    }

    /**
     * @param null $id
     * @return Cache
     */
    protected function getCache($id = null)
    {
        return new Cache($this->arrayCache, $this->dateProvider, self::TEST_NAME, $id);
    }

}
