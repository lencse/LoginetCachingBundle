<?php


namespace Loginet\CachingBundle\Tests\Recorder;


use Loginet\CachingBundle\Cache\Date\DateProviderInterface;
use Loginet\CachingBundle\Recorder\CacheRecorder;
use Loginet\CachingBundle\Tests\Cache\FakeDateProvider;

class CacheRecorderTestBase extends \PHPUnit_Framework_TestCase
{

    /**
     * @var DateProviderInterface
     */
    protected $dateProvider;

    protected function setUp()
    {
        $this->dateProvider = new FakeDateProvider();
        $this->dateProvider->set(new \DateTime('2015-01-01 00:00:00'));
    }

    /**
     * @param CacheRecorder $recorder
     */
    protected function runTestOnNonExpiringCacheRecorder(CacheRecorder $recorder)
    {
        $this->assertEquals('2015-01-01 00:00:00', $recorder->readValue());
        $this->dateProvider->set(new \DateTime('2030-01-01 00:00:00'));
        $this->assertEquals('2015-01-01 00:00:00', $recorder->readValue());
        $recorder->invalidate();
        $this->assertEquals('2030-01-01 00:00:00', $recorder->readValue());
    }

    /**
     * @param CacheRecorder $recorder
     */
    public function runTestOnExpiringCacheRecorder(CacheRecorder $recorder)
    {
        $this->assertEquals('2015-01-01 00:00:00', $recorder->readValue());
        $this->dateProvider->set(new \DateTime('2015-01-01 00:59:00'));
        $this->assertEquals('2015-01-01 00:00:00', $recorder->readValue());
        $this->dateProvider->set(new \DateTime('2015-01-01 01:01:00'));
        $this->assertEquals('2015-01-01 01:01:00', $recorder->readValue());
    }

}
