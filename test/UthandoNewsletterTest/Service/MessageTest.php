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

use UthandoCommon\UthandoException;
use UthandoNewsletter\Model\Message as MessageModel;
use UthandoNewsletter\Model\Newsletter as NewsletterModel;
use UthandoNewsletter\Model\Subscriber;
use UthandoNewsletter\Model\Subscription;
use UthandoNewsletter\Model\Template as TemplateModel;
use UthandoNewsletter\Service\Message;
use UthandoNewsletterTest\Framework\TestCase;

class MessageTest extends TestCase
{
    public function testCanGetFromServiceManager()
    {
        $service = $this->serviceManager
            ->get('UthandoServiceManager')
            ->get('UthandoNewsletterMessage');

        $this->assertInstanceOf(Message::class, $service);
    }

    public function testGetById()
    {
        $messageMapperMock = $this->getMock('UthandoNewsletter\Mapper\Message');
        $messageMapperMock->expects($this->once())->method('getById')->willReturn(new MessageModel());

        $newsletterServiceMock = $this->getMock('UthandoNewsletter\Service\Newsletter');
        $newsletterServiceMock->expects($this->once())->method('getById')->willReturn(new NewsletterModel());

        $templateServiceMock = $this->getMock('UthandoNewsletter\Service\Template');
        $templateServiceMock->expects($this->once())->method('getById')->willReturn(new TemplateModel());

        $this->serviceManager->get('UthandoMapperManager')->setAllowOverride(true);
        $this->serviceManager->get('UthandoServiceManager')->setAllowOverride(true);
        $this->serviceManager->get('UthandoMapperManager')->setService('UthandoNewsletterMessage', $messageMapperMock);
        $this->serviceManager->get('UthandoServiceManager')->setService('UthandoNewsletter', $newsletterServiceMock);
        $this->serviceManager->get('UthandoServiceManager')->setService('UthandoNewsletterTemplate', $templateServiceMock);

        /* @var Message $service */
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
            new Subscription(),
        ];

        $subscribers = [
            new Subscriber(),
        ];

        $messageMapperMock = $this->getMock('UthandoNewsletter\Mapper\Message');
        $messageMapperMock->expects($this->once())->method('getById')->willReturn($messageModel);
        $messageMapperMock->expects($this->once())->method('getPrimaryKey')->willReturn('messageId');

        $subscriptionMapperMock = $this->getMock('UthandoNewsletter\Mapper\Subscription');
        $subscriptionMapperMock->expects($this->once())->method('getSubscriptionsByNewsletterId')->willReturn($subscriptions);

        $subscriberMapperMock = $this->getMock('UthandoNewsletter\Mapper\Subscriber');
        $subscriberMapperMock->expects($this->once())->method('getSubscribersById')->willReturn($subscribers);

        $newsletterServiceMock = $this->getMock('UthandoNewsletter\Service\Newsletter');
        $newsletterServiceMock->expects($this->once())->method('getById')->willReturn(new NewsletterModel());

        $templateServiceMock = $this->getMock('UthandoNewsletter\Service\Template');
        $templateServiceMock->expects($this->once())->method('getById')->willReturn(new TemplateModel());


        $this->serviceManager->get('UthandoMapperManager')->setAllowOverride(true);
        $this->serviceManager->get('UthandoMapperManager')->setService('UthandoNewsletterMessage', $messageMapperMock);
        $this->serviceManager->get('UthandoMapperManager')->setService('UthandoNewsletterSubscription', $subscriptionMapperMock);
        $this->serviceManager->get('UthandoMapperManager')->setService('UthandoNewsletterSubscriber', $subscriberMapperMock);

        $this->serviceManager->get('UthandoServiceManager')->setAllowOverride(true);
        $this->serviceManager->get('UthandoServiceManager')->setService('UthandoNewsletter', $newsletterServiceMock);
        $this->serviceManager->get('UthandoServiceManager')->setService('UthandoNewsletterTemplate', $templateServiceMock);

        /* @var Message $service */
        $service = $this->serviceManager
            ->get('UthandoServiceManager')
            ->get('UthandoNewsletterMessage');
        $service->setUseCache(false);

        $result = $service->sendMessage(1);

        $this->assertSame(1, $result);
    }

    public function testSendMessageWillNotSendAlreadySentMessage()
    {
        $messageModel = new MessageModel();
        $messageModel->setNewsletterId(1)
            ->setSent(true);

        $subscriptions = [
            new Subscription(),
        ];

        $subscribers = [
            new Subscriber(),
        ];

        $messageMapperMock = $this->getMock('UthandoNewsletter\Mapper\Message');
        $messageMapperMock->expects($this->once())->method('getById')->willReturn($messageModel);

        $newsletterServiceMock = $this->getMock('UthandoNewsletter\Service\Newsletter');
        $newsletterServiceMock->expects($this->once())->method('getById')->willReturn(new NewsletterModel());

        $templateServiceMock = $this->getMock('UthandoNewsletter\Service\Template');
        $templateServiceMock->expects($this->once())->method('getById')->willReturn(new TemplateModel());


        $this->serviceManager->get('UthandoMapperManager')->setAllowOverride(true);
        $this->serviceManager->get('UthandoMapperManager')->setService('UthandoNewsletterMessage', $messageMapperMock);

        $this->serviceManager->get('UthandoServiceManager')->setAllowOverride(true);
        $this->serviceManager->get('UthandoServiceManager')->setService('UthandoNewsletter', $newsletterServiceMock);
        $this->serviceManager->get('UthandoServiceManager')->setService('UthandoNewsletterTemplate', $templateServiceMock);

        $this->expectException(UthandoException::class);
        $this->expectExceptionMessage('Cannot send message out again.');

        /* @var Message $service */
        $service = $this->serviceManager
            ->get('UthandoServiceManager')
            ->get('UthandoNewsletterMessage');
        $service->setUseCache(false);

        $result = $service->sendMessage(1);
    }
}
