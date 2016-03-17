<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletterTest\Service
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletterTest\Service;

use UthandoNewsletter\Form\Preferences;
use UthandoNewsletter\Model\Subscriber as SubscriberModel;
use UthandoNewsletter\Model\Subscription;
use UthandoNewsletter\Service\Subscriber;
use UthandoNewsletterTest\Framework\TestCase;

class SubscriberTest extends TestCase
{
    public function testCanGetFromServiceManager()
    {
        $service = $this->serviceManager
            ->get('UthandoServiceManager')
            ->get('UthandoNewsletterSubscriber');

        $this->assertInstanceOf(Subscriber::class, $service);
    }

    public function testGetSubscriberByEmail()
    {
        $subscriber = new SubscriberModel();

        $subscriberMapperMock = $this->getMock('UthandoNewsletter\Mapper\Subscriber');
        $subscriberMapperMock->expects($this->once())->method('getByEmail')->willReturn($subscriber);

        $this->serviceManager->get('UthandoMapperManager')->setAllowOverride(true);
        $this->serviceManager->get('UthandoMapperManager')->setService('UthandoNewsletterSubscriber', $subscriberMapperMock);

        /* @var Subscriber $service */
        $service = $this->serviceManager
            ->get('UthandoServiceManager')
            ->get('UthandoNewsletterSubscriber');

        $result = $service->getSubscriberByEmail('joe@bloggs.com');
        $this->assertInstanceOf(SubscriberModel::class, $result);
    }

    public function testRemoveSubscriberFromList()
    {
        $form = new Preferences();
        
        $post = [

        ];
    }

    public function testGetSubscriberWithSubscriptions()
    {
        $subscriber = new SubscriberModel();
        $subscriptions = [
            new Subscription()
        ];

        $subscriberMapperMock = $this->getMock('UthandoNewsletter\Mapper\Subscriber');
        $subscriberMapperMock->expects($this->once())->method('getById')->willReturn($subscriber);

        $this->serviceManager->get('UthandoMapperManager')->setAllowOverride(true);
        $this->serviceManager->get('UthandoMapperManager')->setService('UthandoNewsletterSubscriber', $subscriberMapperMock);

        $subscriptionServiceMock = $this->getMock('UthandoNewsletter\Service\Subscription');
        $subscriptionServiceMock->expects($this->once())->method('getSubscriptionsBySubscriberId')->willReturn($this->returnValue($subscriptions));

        $this->serviceManager->get('UthandoServiceManager')->setAllowOverride(true);
        $this->serviceManager->get('UthandoServiceManager')->setService('UthandoNewsletterSubscription', $subscriptionServiceMock);

        /* @var Subscriber $service */
        $service = $this->serviceManager
            ->get('UthandoServiceManager')
            ->get('UthandoNewsletterSubscriber');
        $service->setUseCache(false);

        $result = $service->getSubscriberWithSubscriptions(1);
        $this->assertInstanceOf(SubscriberModel::class, $result);
    }
}
