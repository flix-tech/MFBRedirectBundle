<?php

namespace MFB\RedirectBundle\Service;

use MFB\RedirectBundle\Entity\Redirect;

use Doctrine\Common\Cache\AbstractCache;

use Doctrine\ORM\EntityManager;

use MFB\RedirectBundle\Entity\Types\RedirectStatusType;

/**
 * Cms block service
 */
class RedirectService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var AbstractCache
     */
    protected $cache;

    /**
     * @const Cache ID prefix
     */
    const CACHE_PREFIX = 'redirect.';

    /**
     * @const Cache ID prefix
     */
    const CACHE_COLLECTION = 'mfbroutecollection';

    /**
     * @const Cache expiration in seconds
     */
    const CACHE_EXPIRATION = 86400;

    /**
     * @param EntityManager $em         Entity manager
     * @param AbstractCache $cache      Cache driver
     *
     * @return RedirectService
     */
    public function __construct(EntityManager $em, AbstractCache $cache)
    {
        $this->em         = $em;
        $this->cache      = $cache;
    }

    public function getCollection()
    {
        $cacheId = self::CACHE_PREFIX . self::CACHE_COLLECTION;
        if (!$this->cache->contains($cacheId)) {
            $redirects = $this->loadCollectionFromDb();
            $this->cache->save($cacheId, serialize($redirects), self::CACHE_EXPIRATION);
        } else {
            $redirects = unserialize($this->cache->fetch($cacheId));
        }

        return $redirects;
    }

    /**
     * Get block content
     *
     * @todo get from cached collection
     *
     * @param string $name
     *
     * @return string
     */
    public function getTarget($name)
    {
        $target = '';
        $cacheId = self::CACHE_PREFIX . $name;
        if (!$this->cache->contains($cacheId)) {
            $redirectRepository = $this->getRepository();
            /** @var $redirect Redirect */
            $redirect = $redirectRepository->findOneBy(array('slug' => $name, 'status' => RedirectStatusType::ENABLED));

            if ($redirect && ($redirect->getStatus() == RedirectStatusType::ENABLED)) {
                $target = $redirect->getTarget();
            }

            $this->cache->save($cacheId, $target, self::CACHE_EXPIRATION);
        } else {
            $target = $this->cache->fetch($cacheId);
        }

        return $target;
    }

    /**
     * Remove this block from cache
     *
     * @param string $name Block slug
     */
    public function clearCache($name)
    {
        $this->cache->delete(self::CACHE_PREFIX . $name);
        $this->cache->delete(self::CACHE_PREFIX . self::CACHE_COLLECTION);
    }

    /**
     * Load route collection from Database
     *
     * @return array
     */
    protected function loadCollectionFromDb()
    {
        $redirectRepository = $this->getRepository();
        $redirects = $redirectRepository->findBy(array('status' => RedirectStatusType::ENABLED));

        return $redirects;
    }

    /**
     * @return \MFB\RedirectBundle\Entity\Repository\RedirectRepository
     */
    protected function getRepository()
    {
        return $this->em->getRepository('MFBRedirectBundle:Redirect');
    }
}
