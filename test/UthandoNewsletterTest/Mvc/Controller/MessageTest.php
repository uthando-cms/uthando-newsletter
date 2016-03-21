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

use UthandoNewsletter\Mvc\Controller\Message;
use UthandoNewsletter\Service\Message as MessageService;
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
    
    public function testAclRules()
    {
        $serviceManager = $this->getApplicationServiceLocator();

        $resource = 'UthandoNewsletter\Controller\Message';
        $controller = new Message();
        $controller->setServiceLocator($serviceManager);
        $controller->setPluginManager($serviceManager->get('ControllerPluginManager'));
        /* @var \UthandoUser\Controller\Plugin\IsAllowed $acl */
        $acl = $controller->plugin('isAllowed');

        // guest rules
        $this->assertFalse($acl->isAllowed($resource, 'index'));
        $this->assertFalse($acl->isAllowed($resource, 'list'));
        $this->assertFalse($acl->isAllowed($resource, 'add'));
        $this->assertFalse($acl->isAllowed($resource, 'edit'));
        $this->assertFalse($acl->isAllowed($resource, 'delete'));
        $this->assertFalse($acl->isAllowed($resource, 'preview'));
        $this->assertFalse($acl->isAllowed($resource, 'send'));

        // registered user rules
        $identity = $this->getRegisteredUser();
        $acl->setIdentity($controller->identity());
        $this->assertEquals($identity, $acl->getIdentity());
        $this->assertFalse($acl->isAllowed($resource, 'index'));
        $this->assertFalse($acl->isAllowed($resource, 'list'));
        $this->assertFalse($acl->isAllowed($resource, 'add'));
        $this->assertFalse($acl->isAllowed($resource, 'edit'));
        $this->assertFalse($acl->isAllowed($resource, 'delete'));
        $this->assertFalse($acl->isAllowed($resource, 'preview'));
        $this->assertFalse($acl->isAllowed($resource, 'send'));

        // admin user rules
        $identity = $this->getAdminUser();
        $acl->setIdentity($controller->identity());
        $this->assertEquals($identity, $acl->getIdentity());
        $this->assertTrue($acl->isAllowed($resource, 'index'));
        $this->assertTrue($acl->isAllowed($resource, 'list'));
        $this->assertTrue($acl->isAllowed($resource, 'add'));
        $this->assertTrue($acl->isAllowed($resource, 'edit'));
        $this->assertTrue($acl->isAllowed($resource, 'delete'));
        $this->assertTrue($acl->isAllowed($resource, 'preview'));
        $this->assertTrue($acl->isAllowed($resource, 'send'));
    }
}
