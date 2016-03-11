<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\Service
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletter\Service;

use UthandoCommon\Service\AbstractRelationalMapperService;
use UthandoNewsletter\Mapper\Subscriber as SubscriberMapper;
use UthandoNewsletter\Mapper\Subscription as SubscriptionMapper;
use UthandoNewsletter\Model\Subscriber as SubscriberModel;
use UthandoNewsletter\Model\Subscription as SubscriptionModel;
use UthandoNewsletter\View\Model\NewsletterModel;

/**
 * Class Message
 *
 * @package UthandoNewsletter\Service
 */
class Message extends AbstractRelationalMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'UthandoNewsletterMessage';

    /**
     * @var array
     */
    protected $referenceMap = [
        'newsletter'      => [
            'refCol'    => 'newsletterId',
            'service'   => 'UthandoNewsletter',
        ],
        'template'      => [
            'refCol'    => 'templateId',
            'service'   => 'UthandoNewsletterTemplate',
        ],
    ];

    /**
     * @param $id
     * @param null $cols
     * @return array|null|\UthandoNewsletter\Model\Message
     */
    public function getById($id, $cols = null)
    {
        $model = parent::getById($id, $cols);

        $this->populate($model, true);

        return $model;
    }

    /**
     * @param int $id
     * @return int
     */
    public function sendMessage($id)
    {
        $message = $this->getById($id);

        $viewModel = new NewsletterModel();
        $viewModel->setTemplate('message/' . $message->getMessageId());

        /* @var $subscriptionMapper SubscriptionMapper */
        $subscriptionMapper = $this->getService('UthandoNewsletterSubscription')->getMapper();
        $subscriptions = $subscriptionMapper->getSubscriptionsByNewsletterId($message->getNewsletterId());

        $subscriberIds = [];

        /* @var $subscription SubscriptionModel */
        foreach ($subscriptions as $subscription) {
            $subscriberIds[] = $subscription->getSubscriberId();
        }

        /* @var $subscriberMapper SubscriberMapper */
        $subscriberMapper = $this->getService('UthandoNewsletterSubscriber')->getMapper();
        $subscribers = $subscriberMapper->getSubscribersById($subscriberIds);

        $count = 0;

        /* @var $subscriber SubscriberModel */
        foreach ($subscribers as $subscriber) {
            $this->getEventManager()->trigger('mail.queue', $this, [
                'recipient' => [
                    'name' => $subscriber->getName(),
                    'address' => $subscriber->getEmail(),
                ],
                'layout' => $viewModel,
                'body' => null,
                'subject' => $message->getSubject(),
                'renderer' => 'ViewNewsletterRenderer',
                'transport' => 'default',
            ]);
            $count++;
        }

        return $count;
    }
}