<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\Form\Element
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace UthandoNewsletter\Form\Element;

use UthandoNewsletter\Model\Template;
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

    public function init()
    {
        $templates = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('UthandoServiceManager')
            ->get('UthandoNewsletterTemplate')
            ->fetchAll();

        $templateOptions = [];

        /* @var $template Template */
        foreach($templates as $template) {
            $templateOptions[$template->getTemplateId()] = $template->getName();
        }

        $this->setValueOptions($templateOptions);
    }
}