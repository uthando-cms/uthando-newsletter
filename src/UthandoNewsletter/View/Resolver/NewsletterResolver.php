<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\View\Resolver
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace UthandoNewsletter\View\Resolver;

use UthandoNewsletter\Model\Message as MessageModel;
use UthandoNewsletter\Model\Template as TemplateModel;
use UthandoNewsletter\Service\Message;
use UthandoNewsletter\Service\Template;
use Zend\View\Renderer\RendererInterface as Renderer;
use Zend\View\Resolver\ResolverInterface;

/**
 * Class NewsletterResolver
 *
 * @package UthandoNewsletter\View\Resolver
 */
class NewsletterResolver implements ResolverInterface
{
    /**
     * @var Template
     */
    protected $templateService;

    /**
     * @var Message
     */
    protected $messageService;

    /**
     * @param string $name
     * @param Renderer $renderer
     * @return array|null|MessageModel|TemplateModel
     */
    public function resolve($name, Renderer $renderer = null)
    {
        $name = explode('/', $name);

        switch ($name[0]) {
            case 'template':
                $model = $this->getTemplateService()
                    ->getById($name[1]);
                break;
            case 'message':
                $model = $this->getMessageService()
                    ->getById($name[1]);
                break;
            default:
                $model = null;
        }

        return $model;
    }

    /**
     * @return Template
     */
    public function getTemplateService()
    {
        return $this->templateService;
    }

    /**
     * @param Template $templateService
     * @return $this
     */
    public function setTemplateService(Template $templateService)
    {
        $this->templateService = $templateService;
        return $this;
    }

    /**
     * @return Message
     */
    public function getMessageService()
    {
        return $this->messageService;
    }

    /**
     * @param Message $messageService
     * @return $this
     */
    public function setMessageService(Message $messageService)
    {
        $this->messageService = $messageService;
        return $this;
    }
}