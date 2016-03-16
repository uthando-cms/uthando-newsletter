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

use UthandoNewsletter\Model\Newsletter;
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
            ->get('UthandoServiceManager')
            ->get('UthandoNewsletter')
            ->fetchAll();

        $newsletterOptions = [];

        /* @var $newsletter Newsletter */
        foreach($newsletters as $newsletter) {
            $newsletterOptions[$newsletter->getNewsletterId()] = $newsletter->getName();
        }

        return $newsletterOptions;
    }
}
