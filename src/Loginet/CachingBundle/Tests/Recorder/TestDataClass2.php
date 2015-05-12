<?php


namespace Loginet\CachingBundle\Tests\Recorder;


use Loginet\CachingBundle\Cache\Date\DateProviderInterface;
use Loginet\CachingBundle\Recorder\Cacheable;

class TestDataClass2 implements Cacheable
{

    /**
     * @var DateProviderInterface
     */
    public $clock;

    /**
     * @param DateProviderInterface $clock
     */
    function __construct(DateProviderInterface $clock)
    {
        $this->clock = $clock;
    }

    /**
     * @return string
     */
    public function getCacheName()
    {
        return 'test2';
    }

    /**
     * @return string
     */
    public function getCacheId()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getCacheDataAsString()
    {
        return $this->clock->now()->format('Y-m-d H:i:s');
    }

}