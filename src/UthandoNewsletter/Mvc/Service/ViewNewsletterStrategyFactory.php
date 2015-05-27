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

use UthandoNewsletter\View\Renderer\NewsletterRenderer;
use UthandoNewsletter\View\Strategy\NewsletterStrategy;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class ViewNewsletterStrategyFactory
 *
 * @package UthandoNewsletter\Mvc\Service
 */
class ViewNewsletterStrategyFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return NewsletterStrategy
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $newsletterRenderer NewsletterRenderer */
        $newsletterRenderer = $serviceLocator->get('ViewNewsletterRenderer');
        $newsletterStrategy = new NewsletterStrategy($newsletterRenderer);

        return $newsletterStrategy;
    }
}