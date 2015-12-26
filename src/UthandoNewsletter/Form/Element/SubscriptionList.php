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
     * @var bool
     */
    protected $labelPrepend = false;

    /**
     * @var string
     */
    protected $labelHtml = '<i></i>';

    /**
     * @var bool
     */
    protected $preSelect = false;

    /**
     * @var bool
     */
    protected $includeHidden = false;

    /**
     * Setup class
     */
    public function init()
    {
        $this->setName('subscribe');
    }

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

        $newsletters = ($this->isIncludeHidden()) ? $newsletterService->fetchAll() : $newsletterService->fetchVisibleNewsletters();
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

            $options = [
                'label' => $row->getName(),
                'value' => $row->getNewsletterId(),
                'selected' => ($this->isPreSelect()) ? true : $subscribed,
            ];

            if ($this->isLabelPrepend()) {
                $options['label'] =  $this->getLabelHtml() . $options['label'];
                $options['label_options']['disable_html_escape'] = true;
            }

            $valueOptions[] = $options;
        }

        return $valueOptions;
    }

    /**
     * @return boolean
     */
    public function isLabelPrepend()
    {
        return $this->labelPrepend;
    }

    /**
     * @param boolean $labelPrepend
     * @return $this
     */
    public function setLabelPrepend($labelPrepend)
    {
        $this->labelPrepend = $labelPrepend;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabelHtml()
    {
        return $this->labelHtml;
    }

    /**
     * @param string $labelHtml
     * @return $this
     */
    public function setLabelHtml($labelHtml)
    {
        $this->labelHtml = $labelHtml;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isPreSelect()
    {
        return $this->preSelect;
    }

    /**
     * @param boolean $preSelect
     * @return $this
     */
    public function setPreSelect($preSelect)
    {
        $this->preSelect = $preSelect;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isIncludeHidden()
    {
        return $this->includeHidden;
    }

    /**
     * @param boolean $includeHidden
     * @return $this
     */
    public function setIncludeHidden($includeHidden)
    {
        $this->includeHidden = $includeHidden;
        return $this;
    }
}