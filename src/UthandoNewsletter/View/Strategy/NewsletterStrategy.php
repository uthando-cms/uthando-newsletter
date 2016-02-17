<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\View\Strategy
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletter\View\Strategy;

use UthandoNewsletter\View\Model\NewsletterModel;
use UthandoNewsletter\View\Renderer\NewsletterRenderer;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\View\ViewEvent;

/**
 * Class NewsletterStrategy
 *
 * @package UthandoNewsletter\View\Strategy
 */
class NewsletterStrategy extends AbstractListenerAggregate
{
    /**
     * @var NewsletterRenderer
     */
    protected $renderer;

    /**
     * Constructor
     *
     * @param  NewsletterRenderer $renderer
     */
    public function __construct(NewsletterRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * Retrieve the composed renderer
     *
     * @return NewsletterRenderer
     */
    public function getRenderer()
    {
        return $this->renderer;
    }

    /**
     * @param EventManagerInterface $events
     * @param int $priority
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RENDERER, array($this, 'selectRenderer'), $priority);
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RESPONSE, array($this, 'injectResponse'), $priority);
    }

    /**
     * Detect if we should use the NewsletterRenderer based on model type
     *
     * @param  ViewEvent $e
     * @return null|NewsletterRenderer
     */
    public function selectRenderer(ViewEvent $e)
    {
        $model = $e->getModel();

        if ($model instanceof NewsletterModel) {
            return $this->renderer;
        }

        return false;
    }

    /**
     * @param ViewEvent $e
     */
    public function injectResponse(ViewEvent $e)
    {
        $renderer = $e->getRenderer();

        if ($renderer !== $this->renderer) {
            return;
        }

        $result   = $e->getResult();
        $response = $e->getResponse();

        $response->setContent($result);
    }
}