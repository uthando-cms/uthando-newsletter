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

use UthandoNewsletter\Model\Message as MessageModel;
use UthandoNewsletter\Model\Newsletter as NewsletterModel;
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
        $messageMapperMock = $this->getMockBuilder('UthandoNewsletter\Mapper\Message')
            ->disableOriginalConstructor()
            ->getMock();
        $messageMapperMock->expects($this->once())
            ->method('getById')
            ->willReturn(new MessageModel());

        $newsletterServiceMock = $this->getMockBuilder('UthandoNewsletter\Service\Newsletter')
            ->disableOriginalConstructor()
            ->getMock();
        $newsletterServiceMock->expects($this->once())
            ->method('getById')
            ->willReturn(new NewsletterModel());

        $templateServiceMock = $this->getMockBuilder('UthandoNewsletter\Service\Template')
            ->disableOriginalConstructor()
            ->getMock();
        $templateServiceMock->expects($this->once())
            ->method('getById')
            ->willReturn(new TemplateModel());

        $this->serviceManager->get('UthandoMapperManager')->setAllowOverride(true);
        $this->serviceManager->get('UthandoServiceManager')->setAllowOverride(true);
        $this->serviceManager->get('UthandoMapperManager')->setService('UthandoNewsletterMessage', $messageMapperMock);
        $this->serviceManager->get('UthandoServiceManager')->setService('UthandoNewsletter', $newsletterServiceMock);
        $this->serviceManager->get('UthandoServiceManager')->setService('UthandoNewsletterTemplate', $templateServiceMock);

        $service = $this->serviceManager
            ->get('UthandoServiceManager')
            ->get('UthandoNewsletterMessage');

        $service->setUseCache(false);
        $model = $service->getById(1);

        $this->assertInstanceOf(MessageModel::class, $model);
        $this->assertInstanceOf(NewsletterModel::class, $model->getNewsletter());
        $this->assertInstanceOf(TemplateModel::class, $model->getTemplate());
    }
}
