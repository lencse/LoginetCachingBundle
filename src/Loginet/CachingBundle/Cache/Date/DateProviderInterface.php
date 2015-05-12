<?php

namespace Loginet\CachingBundle\Cache\Date;


interface DateProviderInterface
{

    /**
     * @return \DateTime
     */
    public function now();

}