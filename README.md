### MFBRedirectBundle

This bundle adds an entity which you can manage with SonataAdmin to create redirects on the fly.
Very basic implementation and no fail-safes, but routing logic works like a charm.
Depends on Memcache at the moment.

Thanks for the insight to routing to
http://php-and-symfony.matthiasnoback.nl/2012/01/symfony2-dynamically-add-routes/

Add this to your deps file on Symfony2.0

```
[MFBRedirectBundle]
    git=git@github.com:meinfernbusde/MFBRedirectBundle.git
    target=/bundles/MFB/RedirectBundle

[LiipDoctrineCacheBundle]
    git=git@github.com:liip/LiipDoctrineCacheBundle.git
    target=/bundles/Liip/DoctrineCacheBundle
```

Add to autoload.php

```php
    'MFB'              => __DIR__.'/../vendor/bundles',
```
Load bundle in your AppKernel.php

```php
new MFB\RedirectBundle\MFBRedirectBundle(),
```

Enable caching in your config

```yaml
liip_doctrine_cache:
    namespaces:
        # name of the service (aka liip_doctrine_cache.ns.mc)
        mc:
            namespace: mfb
            type: memcache
            # name of a service of class Memcached that is fully configured (optional)
            # id: my_memcached_service
            port: %memcache_port%
            host: %memcache_host%
```

Add data to parameters.ini

```ini
    memcache_host = localhost
    memcache_port = 11211
```

Include bundle in your routing.yml

```yaml
MFBRedirectBundle:
   resource: .
   type: extra
```
