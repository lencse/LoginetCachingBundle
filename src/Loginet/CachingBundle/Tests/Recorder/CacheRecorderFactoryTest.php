<?php


namespace Loginet\CachingBundle\Tests\Recorder;


use Assetic\Cache\ArrayCache;
use Loginet\CachingBundle\Recorder\CacheRecorderFactory;
use Symfony\Component\DependencyInjection\Container;

class CacheRecorderFactoryTest extends CacheRecorderTestBase
{

    /**
     * @var CacheRecorderFactory
     */
    private $factory;

    protected function setUp()
    {
        parent::setUp();
        $container = new Container();
        $container->setParameter('loginet_caching.expiration_second.test1', 'none');
        $container->setParameter('loginet_caching.expiration_second.test2', 3600);
        $this->factory = new CacheRecorderFactory(new ArrayCache(), $container, $this->dateProvider);
    }

    public function testNonExpiringCache()
    {
        $data = new TestDataClass1($this->dateProvider);
        $recorder = $this->factory->createCacheRecorder($data);
        $this->runTestOnNonExpiringCacheRecorder($recorder);
    }

    public function testExpiringCache()
    {
        $data = new TestDataClass2($this->dateProvider);
        $recorder = $this->factory->createCacheRecorder($data);
        $this->runTestOnExpiringCacheRecorder($recorder);
    }

}
