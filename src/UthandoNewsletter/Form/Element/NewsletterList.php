<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\Form\Element
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletter\Form\Element;

use UthandoCommon\Service\ServiceManager;
use UthandoNewsletter\Model\NewsletterModel;
use UthandoNewsletter\Service\NewsletterService;
use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class NewsletterList
 *
 * @package UthandoNewsletter\Form\Element
 */
class NewsletterList extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /**
     * @return array
     */
    public function getValueOptions()
    {
        return ($this->valueOptions) ?: $this->getNewsletters();
    }

    /**
     * return array
     */
    public function getNewsletters()
    {
        $newsletters = $this->getServiceLocator()
            ->getServiceLocator()
            ->get(ServiceManager::class)
            ->get(NewsletterService::class)
            ->fetchAll();

        $newsletterOptions = [];

        /* @var $newsletter NewsletterModel */
        foreach($newsletters as $newsletter) {
            $newsletterOptions[$newsletter->getNewsletterId()] = $newsletter->getName();
        }

        return $newsletterOptions;
    }
}
