<?php


namespace Loginet\CachingBundle\Tests\Cache\Date;


use Loginet\CachingBundle\Cache\Date\DateProvider;

class DateProviderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var DateProvider
     */
    private $provider;

    protected function setUp()
    {
        $this->provider = new DateProvider();
    }

    public function testNow()
    {
        $now = new \DateTime();
        $date = $this->provider->now();
        $this->assertEquals($now->getTimestamp(), $date->getTimestamp(), '', 1);
    }

}
