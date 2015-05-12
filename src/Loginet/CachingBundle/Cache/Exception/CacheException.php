<?php

namespace Loginet\CachingBundle\Cache\Exception;


abstract class CacheException extends \Exception
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $id;

    /**
     * @param string $name
     * @param string $id
     */
    function __construct($name, $id)
    {
        $this->name = $name;
        $this->id = $id;
        parent::__construct($this->getMessageForInit());
    }

    /**
     * @return string
     */
    abstract protected function getMessageForInit();

}