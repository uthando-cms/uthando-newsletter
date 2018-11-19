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

use UthandoNewsletter\Model\MessageModel as MessageModel;
use UthandoNewsletter\Model\NewsletterModel as NewsletterModel;
use UthandoNewsletter\Model\SubscriberModel;
use UthandoNewsletter\Model\SubscriptionModel;
use UthandoNewsletter\Model\TemplateModel as TemplateModel;
use UthandoNewsletter\Service\MessageService;
use UthandoNewsletterTest\Framework\TestCase;

class MessageTest extends TestCase
{
    public function testCanGetFromServiceManager()
    {
        $service = $this->serviceManager
            ->get('UthandoServiceManager')
            ->get('UthandoNewsletterMessage');

        $this->assertInstanceOf(MessageService::class, $service);
    }

    public function testGetById()
    {
        $messageMapperMock = $this->getMock('UthandoNewsletter\Mapper\MessageMapper');
        $messageMapperMock->expects($this->once())->method('getById')->willReturn(new MessageModel());

        $newsletterServiceMock = $this->getMock('UthandoNewsletter\Service\NewsletterService');
        $newsletterServiceMock->expects($this->once())->method('getById')->willReturn(new NewsletterModel());

        $templateServiceMock = $this->getMock('UthandoNewsletter\Service\TemplateService');
        $templateServiceMock->expects($this->once())->method('getById')->willReturn(new TemplateModel());

        $this->serviceManager->get('UthandoMapperManager')->setAllowOverride(true);
        $this->serviceManager->get('UthandoServiceManager')->setAllowOverride(true);
        $this->serviceManager->get('UthandoMapperManager')->setService('UthandoNewsletterMessage', $messageMapperMock);
        $this->serviceManager->get('UthandoServiceManager')->setService('UthandoNewsletter', $newsletterServiceMock);
        $this->serviceManager->get('UthandoServiceManager')->setService('UthandoNewsletterTemplate', $templateServiceMock);

        /* @var MessageService $service */
        $service = $this->serviceManager
            ->get('UthandoServiceManager')
            ->get('UthandoNewsletterMessage');

        $service->setUseCache(false);
        $model = $service->getById(1);

        $this->assertInstanceOf(MessageModel::class, $model);
        $this->assertInstanceOf(NewsletterModel::class, $model->getNewsletter());
        $this->assertInstanceOf(TemplateModel::class, $model->getTemplate());
    }

    public function testSendMessage()
    {
        $messageModel = new MessageModel();
        $messageModel->setNewsletterId(1);

        $subscriptions = [
            new SubscriptionModel(),
        ];

        $subscribers = [
            new SubscriberModel(),
        ];

        $messageMapperMock = $this->getMock('UthandoNewsletter\Mapper\MessageMapper');
        $messageMapperMock->expects($this->once())->method('getById')->willReturn($messageModel);
        $messageMapperMock->expects($this->once())->method('getPrimaryKey')->willReturn('messageId');

        $subscriptionMapperMock = $this->getMock('UthandoNewsletter\Mapper\SubscriptionMapper');
        $subscriptionMapperMock->expects($this->once())->method('getSubscriptionsByNewsletterId')->willReturn($subscriptions);

        $subscriberMapperMock = $this->getMock('UthandoNewsletter\Mapper\SubscriberMapper');
        $subscriberMapperMock->expects($this->once())->method('getSubscribersById')->willReturn($subscribers);

        $newsletterServiceMock = $this->getMock('UthandoNewsletter\Service\NewsletterService');
        $newsletterServiceMock->expects($this->once())->method('getById')->willReturn(new NewsletterModel());

        $templateServiceMock = $this->getMock('UthandoNewsletter\Service\TemplateService');
        $templateServiceMock->expects($this->once())->method('getById')->willReturn(new TemplateModel());


        $this->serviceManager->get('UthandoMapperManager')->setAllowOverride(true);
        $this->serviceManager->get('UthandoMapperManager')->setService('UthandoNewsletterMessage', $messageMapperMock);
        $this->serviceManager->get('UthandoMapperManager')->setService('UthandoNewsletterSubscription', $subscriptionMapperMock);
        $this->serviceManager->get('UthandoMapperManager')->setService('UthandoNewsletterSubscriber', $subscriberMapperMock);

        $this->serviceManager->get('UthandoServiceManager')->setAllowOverride(true);
        $this->serviceManager->get('UthandoServiceManager')->setService('UthandoNewsletter', $newsletterServiceMock);
        $this->serviceManager->get('UthandoServiceManager')->setService('UthandoNewsletterTemplate', $templateServiceMock);

        /* @var MessageService $service */
        $service = $this->serviceManager
            ->get('UthandoServiceManager')
            ->get('UthandoNewsletterMessage');
        $service->setUseCache(false);

        $result = $service->sendMessage(1);

        $this->assertSame(1, $result);
    }

    /**
     * @expectedException \UthandoCommon\UthandoException
     * @expectExceptionMessage Cannot send message out again.
     */
    public function testSendMessageWillNotSendAlreadySentMessage()
    {
        $messageModel = new MessageModel();
        $messageModel->setNewsletterId(1)
            ->setSent(true);

        $subscriptions = [
            new SubscriptionModel(),
        ];

        $subscribers = [
            new SubscriberModel(),
        ];

        $messageMapperMock = $this->getMock('UthandoNewsletter\Mapper\MessageMapper');
        $messageMapperMock->expects($this->once())->method('getById')->willReturn($messageModel);

        $newsletterServiceMock = $this->getMock('UthandoNewsletter\Service\NewsletterService');
        $newsletterServiceMock->expects($this->once())->method('getById')->willReturn(new NewsletterModel());

        $templateServiceMock = $this->getMock('UthandoNewsletter\Service\TemplateService');
        $templateServiceMock->expects($this->once())->method('getById')->willReturn(new TemplateModel());


        $this->serviceManager->get('UthandoMapperManager')->setAllowOverride(true);
        $this->serviceManager->get('UthandoMapperManager')->setService('UthandoNewsletterMessage', $messageMapperMock);

        $this->serviceManager->get('UthandoServiceManager')->setAllowOverride(true);
        $this->serviceManager->get('UthandoServiceManager')->setService('UthandoNewsletter', $newsletterServiceMock);
        $this->serviceManager->get('UthandoServiceManager')->setService('UthandoNewsletterTemplate', $templateServiceMock);

        /* @var MessageService $service */
        $service = $this->serviceManager
            ->get('UthandoServiceManager')
            ->get('UthandoNewsletterMessage');
        $service->setUseCache(false);

        $result = $service->sendMessage(1);
    }
}
