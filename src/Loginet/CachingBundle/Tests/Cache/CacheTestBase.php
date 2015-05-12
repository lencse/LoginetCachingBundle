<?php


namespace Loginet\CachingBundle\Tests\Cache;


use Assetic\Cache\ArrayCache;
use Loginet\CachingBundle\Cache\CacheInterface;
use Loginet\CachingBundle\Cache\Date\DateProviderInterface;

abstract class CacheTestBase extends \PHPUnit_Framework_TestCase
{

    const TEST_VALUE = 'test';
    const TEST_NAME = 'dummy';

    /**
     * @var CacheInterface
     */
    protected $arrayCache;

    /**
     * @var DateProviderInterface
     */
    protected $dateProvider;

    protected function setUp()
    {
        $this->arrayCache = new ArrayCache();
        $this->dateProvider = new FakeDateProvider();
        $this->dateProvider->set(new \DateTime('2015-01-01 00:00:00'));
    }

    /**
     * @param string $id
     * @return CacheInterface
     */
    abstract protected function getCache($id = null);

}