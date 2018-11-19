<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\View\Resolver
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletter\View\Resolver;

use UthandoNewsletter\Model\MessageModel as MessageModel;
use UthandoNewsletter\Model\TemplateModel as TemplateModel;
use UthandoNewsletter\Service\MessageService;
use UthandoNewsletter\Service\TemplateService;
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
     * @var TemplateService
     */
    protected $templateService;

    /**
     * @var MessageService
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
     * @return TemplateService
     */
    public function getTemplateService()
    {
        return $this->templateService;
    }

    /**
     * @param TemplateService $templateService
     * @return $this
     */
    public function setTemplateService(TemplateService $templateService)
    {
        $this->templateService = $templateService;
        return $this;
    }

    /**
     * @return MessageService
     */
    public function getMessageService()
    {
        return $this->messageService;
    }

    /**
     * @param MessageService $messageService
     * @return $this
     */
    public function setMessageService(MessageService $messageService)
    {
        $this->messageService = $messageService;
        return $this;
    }
}