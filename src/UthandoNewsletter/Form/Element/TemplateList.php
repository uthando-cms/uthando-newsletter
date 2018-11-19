<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\Form\Element
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletter\Form\Element;

use UthandoCommon\Service\ServiceManager;
use UthandoNewsletter\Model\TemplateModel;
use UthandoNewsletter\Service\TemplateService;
use Zend\Form\Element\Select;
use Zend\Form\FormElementManager;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class TemplateList
 *
 * @package UthandoNewsletter\Form\Element
 * @method FormElementManager getServiceLocator()
 */
class TemplateList extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /**
     * @return array
     */
    public function getValueOptions()
    {
        return ($this->valueOptions) ?: $this->getTemplates();
    }

    /**
     * @return array
     */
    public function getTemplates()
    {
        $templates = $this->getServiceLocator()
            ->getServiceLocator()
            ->get(ServiceManager::class)
            ->get(TemplateService::class)
            ->fetchAll();

        $templateOptions = [];

        /* @var $template TemplateModel */
        foreach($templates as $template) {
            $templateOptions[$template->getTemplateId()] = $template->getName();
        }

        return $templateOptions;
    }
}