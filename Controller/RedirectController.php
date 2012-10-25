<?php

namespace MFB\RedirectBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Menu controller
 */
class RedirectController extends Controller
{
    public function extraRouteAction()
    {
        /**
         * @var \Symfony\Component\HttpFoundation\Request   $request
         * @var \MFB\RedirectBundle\Service\RedirectService $redirectService
         */
        $request = $this->get('request');
        $redirectService = $this->get('mfb_redirect.service.redirect');
        $url = $request->getRequestUri();
        $targetUrl = $redirectService->getTarget($url);

        return new RedirectResponse($targetUrl);
    }

}