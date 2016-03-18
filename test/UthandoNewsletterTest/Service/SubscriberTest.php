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
use UthandoNewsletter\Model\Newsletter;
use UthandoNewsletter\Model\Subscriber as SubscriberModel;
use UthandoNewsletter\Model\Subscription;
use UthandoNewsletter\Service\Subscriber;
use UthandoNewsletterTest\Framework\TestCase;
use Zend\EventManager\Event;

class SubscriberTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $subscriptionModel = new Subscription();
        $subscriptionModel->setSubscriptionId(1)
            ->setNewsletterId(1)
            ->setSubscriberId(1);

        $subscriptions = [
            $subscriptionModel
        ];

        $subscriber = new SubscriberModel();
        $subscriber->setSubscriberId(1)
            ->setEmail('joe@bloggs.com')
            ->setName('Joe Bloggs')
            ->setSubscriptions($subscriptions);

        $subscriberMapperMock = $this->getMock('UthandoNewsletter\Mapper\Subscriber');
        $subscriberMapperMock->expects($this->any())->method('getById')->willReturn($subscriber);
        $subscriberMapperMock->expects($this->any())->method('getByEmail')->willReturn($subscriber);
        $subscriberMapperMock->expects($this->any())->method('getPrimaryKey')->willReturn('subscriberId');
        $subscriberMapperMock->expects($this->any())->method('delete')->willReturn(1);

        $this->serviceManager->get('UthandoMapperManager')->setAllowOverride(true);
        $this->serviceManager->get('UthandoMapperManager')->setService('UthandoNewsletterSubscriber', $subscriberMapperMock);

        $subscriptionServiceMock = $this->getMock('UthandoNewsletter\Service\Subscription');
        $subscriptionServiceMock->expects($this->any())->method('getSubscriptionsBySubscriberId')->willReturn($subscriptions);
        $subscriptionServiceMock->expects($this->any())->method('delete')->willReturn(1);

        $this->serviceManager->get('UthandoServiceManager')->setAllowOverride(true);
        $this->serviceManager->get('UthandoServiceManager')->setService('UthandoNewsletterSubscription', $subscriptionServiceMock);

        $newsletterModel = new Newsletter();
        $newsletterModel->setNewsletterId(1);

        $newsletterServiceMock = $this->getMock('UthandoNewsletter\Service\Newsletter');
        $newsletterServiceMock->expects($this->any())->method('fetchAll')->willReturn([$newsletterModel]);

        $this->serviceManager->get('UthandoServiceManager')->setService('UthandoNewsletter', $newsletterServiceMock);

    }

    /**
     * @return Subscriber
     */
    public function getService()
    {
        $service = new Subscriber();
        $service->setUseCache(false);
        $service->setServiceLocator($this->serviceManager->get('UthandoServiceManager'));
        return $service;
    }

    public function testCanGetFromServiceManager()
    {
        $service = $this->serviceManager
            ->get('UthandoServiceManager')
            ->get('UthandoNewsletterSubscriber');

        $this->assertInstanceOf(Subscriber::class, $service);
    }

    public function testGetSubscriberByEmail()
    {
        $service = $this->getService();

        $result = $service->getSubscriberByEmail('joe@bloggs.com');
        $this->assertInstanceOf(SubscriberModel::class, $result);
    }

    public function testRemoveSubscriberFromList()
    {
        $service = $this->getService();

        // test validation fail returns instance of Preferences.
        $form = $this->serviceManager->get('FormElementManager')->get('UthandoNewsletterPreferences');

        $result = $service->removeSubscriberFromList([], $form);

        $this->assertInstanceOf(Preferences::class, $result);

        // test form pass returns affected row.
        $formMock = $this->getMock('UthandoNewsletter\Form\Preferences');
        $formMock->expects($this->once())->method('isValid')->willReturn($this->returnValue(true));

        $this->serviceManager->get('FormElementManager')->setAllowOverride(true);
        $this->serviceManager->get('FormElementManager')->setService('UthandoNewsletterPreferences', $formMock);

        $form = $this->serviceManager->get('FormElementManager')->get('UthandoNewsletterPreferences');

        $result = $service->removeSubscriberFromList([
            'email' => 'joe@bloggs.com',
            'security' => '',
            'captcha' => '',
        ], $form);

        $this->assertEquals(1, $result);
    }

    public function testGetSubscriberWithSubscriptions()
    {
        $service = $this->getService();

        $result = $service->getSubscriberWithSubscriptions(1);
        $this->assertInstanceOf(SubscriberModel::class, $result);
    }

    public function testUpdateSubscriptionsReturnsFalse()
    {
        $event = new Event();

        $subscriberModel = new SubscriberModel();
        $subscriberModel->setSubscriberId(1)
            ->setEmail('joe@bloggs.com')
            ->setName('Joe Bloggs')
            ->setSubscribe([1]);

        $form = $this->getMock('UthandoNewsletter\Form\Subscriber');
        $form->expects($this->once())->method('getData')->willReturn($subscriberModel);

        $event->setParams([
            'form' => $form,
            'saved' => 1,
        ]);

        $service = $this->getService();
        $service->updateSubscriptions($event);

        $this->assertFalse($event->getParam('result'));
    }

    public function testUpdateSubscriptionsReturnsAffectedRowWhenUnsubscribing()
    {
        $event = new Event();

        $subscriberModel = new SubscriberModel();
        $subscriberModel->setSubscriberId(1)
            ->setEmail('joe@bloggs.com')
            ->setName('Joe Bloggs')
            ->setSubscribe([]);

        $form = $this->getMock('UthandoNewsletter\Form\Subscriber');
        $form->expects($this->once())->method('getData')->willReturn($subscriberModel);

        $event->setParams([
            'form' => $form,
            'saved' => 1,
        ]);

        $service = $this->getService();
        $service->updateSubscriptions($event);

        $this->assertEquals(1, $event->getParam('result'));
    }

    public function testUpdateSubscriptionsReturnsAffectedRowWhenSubscribing()
    {
        $event = new Event();

        $subscriberModel = new SubscriberModel();
        $subscriberModel->setSubscriberId(1)
            ->setEmail('joe@bloggs.com')
            ->setName('Joe Bloggs')
            ->setSubscribe([1]);

        $form = $this->getMock('UthandoNewsletter\Form\Subscriber');
        $form->expects($this->once())->method('getData')->willReturn($subscriberModel);

        $event->setParams([
            'form' => $form,
            'saved' => 1,
        ]);

        $subscriptionServiceMock = $this->getMock('UthandoNewsletter\Service\Subscription');
        $subscriptionServiceMock->expects($this->any())->method('getSubscriptionsBySubscriberId')->willReturn([]);
        $subscriptionServiceMock->expects($this->any())->method('save')->willReturn(1);
        $this->serviceManager->get('UthandoServiceManager')->setService('UthandoNewsletterSubscription', $subscriptionServiceMock);

        $service = $this->getService();
        $service->updateSubscriptions($event);

        $this->assertEquals(1, $event->getParam('result'));
    }
}
