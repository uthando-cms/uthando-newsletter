<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\Service
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace UthandoNewsletter\Service;

use UthandoCommon\Service\AbstractRelationalMapperService;
use UthandoNewsletter\Form\Subscriber as SubscriberForm;
use UthandoNewsletter\Model\Subscriber as SubscriberModel;
use Zend\EventManager\Event;

/**
 * Class Newsletter
 *
 * @package UthandoNewsletter\Service
 * @method SubscriberModel getModel($model = null)
 */
class Subscriber extends AbstractRelationalMapperService
{
    protected $serviceAlias = 'UthandoNewsletterSubscriber';

    /**
     * @var array
     */
    protected $referenceMap = [
        'subscriptions'      => [
            'refCol'    => 'subscriberId',
            'service'   => 'UthandoNewsletterSubscription',
            'getMethod' => 'getSubscriptionsBySubscriberId',
        ],
    ];

    /**
     * attach events
     */
    public function attachEvents()
    {
        $this->getEventManager()->attach([
            'post.edit', 'post.add',
        ], [$this, 'updateSubscriptions']);
    }

    public function getSubscriberByEmail($email)
    {
        return $this->getMapper()->getByEmail($email);
    }

    /**
     * @param $id
     * @return \UthandoNewsletter\Model\Subscriber
     */
    public function getSubscriberWithSubscriptions($id)
    {
        $model = parent::getById($id);

        $this->populate($model, true);

        return $model;
    }

    /**
     * @param Event $e
     * @throws \UthandoCommon\Service\ServiceException
     */
    public function updateSubscriptions(Event $e)
    {
        /* @var $form SubscriberForm */
        $form = $e->getParam('form');
        /* @var $model SubscriberModel */
        $model = $form->getData();
        $subscriberId = $e->getParam('saved', $model->getSubscriberId());

        /* @var $newsletterService \UthandoNewsletter\Service\Newsletter */
        $newsletterService = $this->getService('UthandoNewsletter');

        /* @var $subscriptionService \UthandoNewsletter\Service\Subscription */
        $subscriptionService =  $this->getService('UthandoNewsletterSubscription');

        $newsletters = $newsletterService->fetchAll();

        $subscriber = $this->getSubscriberWithSubscriptions($subscriberId);

        $subscribe = $model->getSubscribe();
        $result = false;

        // if we have a subscriber id then update subscriptions
        // where values are positive
        if ($subscriberId) {
            /* @var $newsletter \UthandoNewsletter\Model\Newsletter */
            foreach ($newsletters as $newsletter) {
                $subscribeToNewsletter = in_array($newsletter->getNewsletterId(), $subscribe);
                $subscription = $subscriber->getSubscriptions($newsletter->getNewsletterId());

                // if we want to subscribe and no record exists
                if (!$subscription && $subscribeToNewsletter) {
                    $result = $subscriptionService->save([
                        'subscriptionId' => null,
                        'newsletterId' => $newsletter->getNewsletterId(),
                        'subscriberId' => $subscriber->getSubscriberId(),
                    ]);
                }

                // if we want to un-subscribe
                if ($subscription && !$subscribeToNewsletter) {
                    $result = $subscriptionService->delete($subscription->getSubscriptionId());
                }
            }
        }

        if ($result) {
            $e->setParam('result', $result);
        }
    }
}