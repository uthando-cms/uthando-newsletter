<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletterTest\Mvc\Controller
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletterTest\Mvc\Controller;

use UthandoNewsletter\Mvc\Controller\MessageController;
use UthandoNewsletter\Service\MessageService as MessageService;
use UthandoNewsletterTest\Framework\ApplicationTestCase;

class MessageTest extends ApplicationTestCase
{
    public function setUp()
    {
        parent::setUp();

        $messageServiceMock = $this->getMock(MessageService::class);

        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);
        $serviceManager->get('UthandoServiceManager')->setService('UthandoNewsletterMessage', $messageServiceMock);
    }

    public function testPreviewAction()
    {
        $controller = new MessageController();
    }

    public function testIndexActionCanBeAccessed()
    {
        $this->getAdminUser();
        $this->dispatch('/admin/newsletter/message');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('UthandoNewsletter');
        $this->assertControllerName('UthandoNewsletter\Controller\Message');
        $this->assertControllerClass('Message');
        $this->assertMatchedRouteName('admin/newsletter/message');
    }
}
