# Caching

Caching in Loginet Platform is quite simple, you need to do 3 steps:

1. Create a class that produces data to be stored in cache (implementing the Cacheable interface)
1. Set up the lifetime of the cache in a config parameter.
1. Use a Cache Recorder, that manages your data and decides if it's can be retrivied from cache or not.

You can get the data from the cache recorder: if the cache is present, and not expired, it gives the data from cache, otherwise it uses the Cachable object to calculate data and stores it n the cache.

**Example:** Imagine you have to provide a huge XML for each users with the past orders, browsing history etc. The XML is queried several times, but it doesn't have to be up to date: it can be refreshed once in an hour.

## 1. The Cacheable class

```php
use Loginet\CachingBundle\Recorder\Cacheable;


class UserXml implements Loginet\CachingBundle\Recorder\Cacheable
{

    /**
      * @var User
      */
    private $user;

    //...

    /**
     * @return string
     */
    public function getCacheName()
    {
        return 'user_xml';
    }

    /**
     * @return string
     */
    public function getCacheId()
    {
        return $this->user->getId();
    }

    /**
     * @return string
     */
    public function getCacheDataAsString()
    {
        // Put expensive (time, database queries etc.) code here
        return $xml;
    }

}
```
In this class you have to implement 3 methods:

1. Cache name: This identifies the *type* of the cache, lifetime can be set up invidually for these caches.
1. Cache ID: There can be a lot of cache instances for the same type, in this example we use the user id to distinguish between them.
1. Cache data as string: This is the code that only executed when the data can not be retrivied from cache.

## 2. The cache lifetime config parameter

```yml
parameters:
    loginet_caching.expiration_second.user_xml: 3600
```

There you can set up the lifetime in seconds for named cache instances. It can be an integer which is treated as seconds or `none` that means it never expires: you can invalidate and refresh the cache on demand.

```yml
parameters:
    loginet_caching.expiration_second.never_expiring: none
```

## 3. The Cache Recorder

```php
$userXml = new UserXml();
// ...

// In a controller that extends Loginet's base Controller, you can use $this->getCacheRecorderFactory()
$cacheRecorder = $this->container->get('loginet_caching.recorder_factory')->createCacheRecorder($userXml);

$xml = $cacheRecorder->readValue();
```

The recorder is created by a factory service. If you use the cache recorder's `readValue` method, the XML is only being generated on the first query, then it's read from the cache for a hour.

If the data has to be recalculated for some reasons, you can invalidate the cache and force the recorder to generate it again.

```php
$cacheRecorder->invalidate();
```
