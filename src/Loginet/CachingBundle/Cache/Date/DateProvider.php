<?php


namespace Loginet\CachingBundle\Cache\Date;


class DateProvider implements DateProviderInterface
{

    /**
     * @return \DateTime
     */
    public function now()
    {
        return new \DateTime();
    }

}