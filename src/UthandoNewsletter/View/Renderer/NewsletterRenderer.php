<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\View\Renderer
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace UthandoNewsletter\View\Renderer;

use UthandoNewsletter\Model\Message;
use UthandoNewsletter\Model\Template;
use UthandoNewsletter\View\Model\NewsletterModel;
use UthandoNewsletter\View\Renderer\NewsletterEngine;
use UthandoNewsletter\View\Resolver\NewsletterResolver;
use Zend\View\Exception\DomainException;
use Zend\View\Exception\RuntimeException;
use Zend\View\Renderer\RendererInterface;
use Zend\View\Resolver\ResolverInterface;

/**
 * Class NewsletterRenderer
 *
 * @package UthandoNewsletter\View\Renderer
 */
class NewsletterRenderer implements RendererInterface
{
    /**
     * @var NewsletterResolver
     */
    protected $resolver = null;

    /**
     * @var NewsletterEngine
     */
    protected $engine;

    /**
     * @param ResolverInterface $resolver
     * @return $this
     */
    public function setResolver(ResolverInterface $resolver)
    {
        $this->resolver = $resolver;
        return $this;
    }

    /**
     * @param null $name
     * @return array|null|Message|Template|NewsletterResolver
     */
    public function resolver($name = null)
    {
        if (null !== $name) {
            return $this->resolver->resolve($name, $this);
        }

        return $this->resolver;
    }

    /**
     * @return NewsletterEngine
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * @param NewsletterEngine $engine
     * @return $this
     */
    public function setEngine(NewsletterEngine $engine)
    {
        $this->engine = $engine;
        return $this;
    }

    /**
     * @param string|\Zend\View\Model\ModelInterface $nameOrModel
     * @param null $values
     * @return string
     */
    public function render($nameOrModel, $values = null)
    {
        if ($nameOrModel instanceof NewsletterModel) {
            $model       = $nameOrModel;
            $nameOrModel = $model->getTemplate();
            if (empty($nameOrModel)) {
                throw new DomainException(sprintf(
                    '%s: received View Model argument, but template is empty',
                    __METHOD__
                ));
            }

            $this->getEngine()->setVariables($model->getVariables());
            unset($model);
        }

        $model = $this->resolver($nameOrModel);

        if (!$model) {
            throw new RuntimeException(sprintf(
                '%s: Unable to render template "%s"; resolver could not resolve to a table row',
                __METHOD__,
                $nameOrModel
            ));
        }

        return $this->getEngine()->render($model);
    }
}