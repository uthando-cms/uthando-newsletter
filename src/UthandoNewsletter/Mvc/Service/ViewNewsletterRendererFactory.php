<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\Mvc\Service
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace UthandoNewsletter\Mvc\Service;

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
class ViewNewsletterRendererFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return NewsletterRenderer
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = $serviceLocator->get('UthandoServiceManager');
        $templateService = $serviceLocator->get('UthandoNewsletterTemplate');
        $messageService = $serviceLocator->get('UthandoNewsletterMessage');

        $viewResolver = new NewsletterResolver();

        $viewResolver->setTemplateService($templateService);
        $viewResolver->setMessageService($messageService);

        $newsletterRenderer = new NewsletterRenderer();
        $newsletterRenderer->setResolver($viewResolver);
        $newsletterRenderer->setEngine(new NewsletterEngine());

        return $newsletterRenderer;
    }
}