<?php

namespace MFB\RedirectBundle\Routing;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use MFB\RedirectBundle\Service\RedirectService;
use MFB\RedirectBundle\Entity\Redirect;

class ExtraLoader implements LoaderInterface
{
    /**
     * @var bool $loaded
     */
    private $loaded = false;

    /**
     * @var RedirectService $redirectService
     */
    private $redirectService;

    /**
     * @param RedirectService $redirectService
     *
     * return ExtraLoader
     */
    public function __construct($redirectService)
    {
        $this->redirectService = $redirectService;
    }

    public function load($resource, $type = null)
    {
        if (true === $this->loaded) {
            throw new \RuntimeException('Do not add this loader twice');
        }

        $routes = new RouteCollection();

        $routeDb = $this->redirectService->getCollection();
        if (count($routeDb) < 1) {
            return $routes;
        }
        $i = 1;
        /**
         * @var Redirect $rawRoute
         */
        foreach ($routeDb as $rawRoute) {
            $pattern = $rawRoute->getSlug();
            $defaults = array(
                '_controller' => 'MFBRedirectBundle:Redirect:extraRoute',
            );

            $route = new Route($pattern, $defaults);
            $routes->add('mfbredirect.' . $i, $route);
            $i++;
        }

        return $routes;
    }

    public function supports($resource, $type = null)
    {
        return 'extra' === $type;
    }

    public function getResolver()
    {
    }

    public function setResolver(LoaderResolver $resolver)
    {
        // irrelevant to us, since we don't need a resolver
    }
}