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

    /**
     * Get block content
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
            /** @var $blockRepository \MFB\RedirectBundle\Entity\Repository\RedirectRepository */
            $blockRepository = $this->em->getRepository('MFBRedirectBundle:Redirect');
            /** @var $block Redirect */
            $redirect = $blockRepository->findOneBy(array('slug' => $name, 'status' => RedirectStatusType::ENABLED));

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
        $cacheId = self::CACHE_PREFIX . $name;
        $this->cache->delete($cacheId);
    }
}
