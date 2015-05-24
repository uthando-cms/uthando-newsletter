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

use UthandoNewsletter\Service\Subscription;
use UthandoNewsletter\Model\Newsletter as NewsletterModel;
use UthandoNewsletter\Service\Newsletter;
use uthandoNewsletter\Model\Subscription as SubscriptionModel;
use Zend\Form\Element\MultiCheckbox;
use Zend\Form\FormElementManager;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class SubscriptionList
 *
 * @package UthandoNewsletter\Form\Element
 * @method FormElementManager getServiceLocator()
 */
class SubscriptionList extends MultiCheckbox implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /**
     * @var int
     */
    protected $subscriberId;

    /**
     * @return int
     */
    public function getSubscriberId()
    {
        return $this->subscriberId;
    }

    /**
     * @param int $subscriberId
     * @return $this
     */
    public function setSubscriberId($subscriberId)
    {
        $this->subscriberId = $subscriberId;
        return $this;
    }

    public function setOptions($options)
    {
        if (isset($options['subscriber_id'])) {
            $this->subscriberId = $options['subscriber_id'];
        }

        parent::setOptions($options);
    }

    public function getValueOptions()
    {
        return ($this->valueOptions) ?: $this->getSubscribers();
    }

    public function getSubscribers()
    {
        /* @var $sm \UthandoCommon\Service\ServiceManager */
        $sm = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('UthandoServiceManager');

        /* @var $newsletterService Newsletter */
        $newsletterService = $sm->get('UthandoNewsletter');

        /* @var $subscriptionsService Subscription */
        $subscriptionsService = $sm->get('UthandoNewsletterSubscription');

        $newsletters = $newsletterService->getMapper()->fetchAll();
        $subscriptions = $subscriptionsService->getMapper()
            ->getSubscriptionsBySubscriberId($this->getSubscriberId());

        $valueOptions = [];

        /* @var $row NewsletterModel */
        foreach ($newsletters as $row) {

            $subscribed = false;

            /* @var $sub SubscriptionModel */
            foreach ($subscriptions as $sub) {
                if ($sub->getNewsletterId() == $row->getNewsletterId()) {
                    $subscribed = true;
                }
            }

            $valueOptions[] = [
                'label' => $row->getName(),
                'value' => $row->getNewsletterId(),
                'selected' => $subscribed,
            ];
        }

        return $valueOptions;
    }
}