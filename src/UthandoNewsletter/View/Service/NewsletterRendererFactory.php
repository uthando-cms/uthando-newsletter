<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\Mvc\Service
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletter\View\Service;

use UthandoCommon\Service\ServiceManager;
use UthandoNewsletter\Service\MessageService;
use UthandoNewsletter\Service\TemplateService;
use UthandoNewsletter\View\Renderer\NewsletterEngine;
use UthandoNewsletter\View\Renderer\NewsletterRenderer;
use UthandoNewsletter\View\Resolver\NewsletterResolver;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class ViewNewsletterRendererFactory
 *
 * @package UthandoNewsletter\Mvc\Service
 */
class NewsletterRendererFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return NewsletterRenderer
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator     = $serviceLocator->get(ServiceManager::class);
        $templateService    = $serviceLocator->get(TemplateService::class);
        $messageService     = $serviceLocator->get(MessageService::class);
        $urlHelper          = $serviceLocator->get('ViewHelperManager')->get('url');

        $viewResolver       = new NewsletterResolver();
        $newsletterRenderer = new NewsletterRenderer();
        $engine             = new NewsletterEngine();

        $viewResolver->setTemplateService($templateService);
        $viewResolver->setMessageService($messageService);

        $engine->setUrlHelper($urlHelper);

        $newsletterRenderer->setResolver($viewResolver);
        $newsletterRenderer->setEngine($engine);

        return $newsletterRenderer;
    }
}