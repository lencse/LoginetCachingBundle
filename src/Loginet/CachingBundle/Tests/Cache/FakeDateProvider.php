<?php


namespace Loginet\CachingBundle\Tests\Cache;


use Loginet\CachingBundle\Cache\Date\DateProviderInterface;

class FakeDateProvider implements DateProviderInterface
{

    /**
     * @var \DateTime
     */
    private $current;

    /**
     * @return \DateTime
     */
    public function now()
    {
        return $this->current;
    }

    /**
     * @param \DateTime $current
     */
    public function set(\DateTime $current)
    {
        $this->current = $current;
    }

}