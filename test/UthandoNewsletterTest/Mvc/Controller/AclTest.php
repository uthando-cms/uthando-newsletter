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
use UthandoNewsletter\Mvc\Controller\NewsletterController;
use UthandoNewsletter\Mvc\Controller\PreferencesController;
use UthandoNewsletter\Mvc\Controller\SettingsController;
use UthandoNewsletter\Mvc\Controller\SubscriberController;
use UthandoNewsletter\Mvc\Controller\SubscriberAdmin;
use UthandoNewsletter\Mvc\Controller\TemplateController;
use UthandoNewsletterTest\Framework\TestCase;
use Zend\Permissions\Acl\Role\GenericRole;

class AclTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testMessageControllerRules()
    {
        $serviceManager = $this->getServiceManager();

        $resource = 'UthandoNewsletter\Controller\Message';
        $controller = new MessageController();
        $controller->setServiceLocator($serviceManager);
        $controller->setPluginManager($serviceManager->get('ControllerPluginManager'));
        /* @var \UthandoUser\Controller\Plugin\IsAllowed $acl */
        $acl = $controller->plugin('isAllowed');

        // guest rules
        $identity = null;
        $acl->setIdentity($identity);
        $this->assertInstanceOf(GenericRole::class, $acl->getIdentity());
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

    public function testNewsletterControllerRules()
    {
        $serviceManager = $this->getServiceManager();

        $resource = 'UthandoNewsletter\Controller\Newsletter';
        $controller = new NewsletterController();
        $controller->setServiceLocator($serviceManager);
        $controller->setPluginManager($serviceManager->get('ControllerPluginManager'));
        /* @var \UthandoUser\Controller\Plugin\IsAllowed $acl */
        $acl = $controller->plugin('isAllowed');

        // guest rules
        $identity = null;
        $acl->setIdentity($identity);
        $this->assertInstanceOf(GenericRole::class, $acl->getIdentity());
        $this->assertFalse($acl->isAllowed($resource, 'index'));
        $this->assertFalse($acl->isAllowed($resource, 'list'));
        $this->assertFalse($acl->isAllowed($resource, 'add'));
        $this->assertFalse($acl->isAllowed($resource, 'edit'));
        $this->assertFalse($acl->isAllowed($resource, 'delete'));
        $this->assertFalse($acl->isAllowed($resource, 'set-visible'));


        // registered user rules
        $identity = $this->getRegisteredUser();
        $acl->setIdentity($controller->identity());
        $this->assertEquals($identity, $acl->getIdentity());
        $this->assertFalse($acl->isAllowed($resource, 'index'));
        $this->assertFalse($acl->isAllowed($resource, 'list'));
        $this->assertFalse($acl->isAllowed($resource, 'add'));
        $this->assertFalse($acl->isAllowed($resource, 'edit'));
        $this->assertFalse($acl->isAllowed($resource, 'delete'));
        $this->assertFalse($acl->isAllowed($resource, 'set-visible'));

        // admin user rules
        $identity = $this->getAdminUser();
        $acl->setIdentity($controller->identity());
        $this->assertEquals($identity, $acl->getIdentity());
        $this->assertTrue($acl->isAllowed($resource, 'index'));
        $this->assertTrue($acl->isAllowed($resource, 'list'));
        $this->assertTrue($acl->isAllowed($resource, 'add'));
        $this->assertTrue($acl->isAllowed($resource, 'edit'));
        $this->assertTrue($acl->isAllowed($resource, 'delete'));
        $this->assertTrue($acl->isAllowed($resource, 'set-visible'));
    }

    public function testPreferencesControllerRules()
    {
        $serviceManager = $this->getServiceManager();

        $resource = 'UthandoNewsletter\Controller\Preferences';
        $controller = new PreferencesController();
        $controller->setServiceLocator($serviceManager);
        $controller->setPluginManager($serviceManager->get('ControllerPluginManager'));
        /* @var \UthandoUser\Controller\Plugin\IsAllowed $acl */
        $acl = $controller->plugin('isAllowed');

        // guest rules
        $identity = null;
        $acl->setIdentity($identity);
        $this->assertInstanceOf(GenericRole::class, $acl->getIdentity());
        $this->assertTrue($acl->isAllowed($resource, 'index'));


        // registered user rules
        $identity = $this->getRegisteredUser();
        $acl->setIdentity($controller->identity());
        $this->assertEquals($identity, $acl->getIdentity());
        $this->assertTrue($acl->isAllowed($resource, 'index'));

        // admin user rules
        $identity = $this->getAdminUser();
        $acl->setIdentity($controller->identity());
        $this->assertEquals($identity, $acl->getIdentity());
        $this->assertTrue($acl->isAllowed($resource, 'index'));
    }

    public function testSettingsControllerRules()
    {
        $serviceManager = $this->getServiceManager();

        $resource = 'UthandoNewsletter\Controller\Settings';
        $controller = new SettingsController();
        $controller->setServiceLocator($serviceManager);
        $controller->setPluginManager($serviceManager->get('ControllerPluginManager'));
        /* @var \UthandoUser\Controller\Plugin\IsAllowed $acl */
        $acl = $controller->plugin('isAllowed');

        // guest rules
        $identity = null;
        $acl->setIdentity($identity);
        $this->assertInstanceOf(GenericRole::class, $acl->getIdentity());
        $this->assertFalse($acl->isAllowed($resource, 'index'));


        // registered user rules
        $identity = $this->getRegisteredUser();
        $acl->setIdentity($controller->identity());
        $this->assertEquals($identity, $acl->getIdentity());
        $this->assertFalse($acl->isAllowed($resource, 'index'));

        // admin user rules
        $identity = $this->getAdminUser();
        $acl->setIdentity($controller->identity());
        $this->assertEquals($identity, $acl->getIdentity());
        $this->assertTrue($acl->isAllowed($resource, 'index'));
    }

    public function testSubscriberControllerRules()
    {
        $serviceManager = $this->getServiceManager();

        $resource = 'UthandoNewsletter\Controller\Subscriber';
        $controller = new SubscriberController();
        $controller->setServiceLocator($serviceManager);
        $controller->setPluginManager($serviceManager->get('ControllerPluginManager'));
        /* @var \UthandoUser\Controller\Plugin\IsAllowed $acl */
        $acl = $controller->plugin('isAllowed');

        // guest rules
        $identity = null;
        $acl->setIdentity($identity);
        $this->assertInstanceOf(GenericRole::class, $acl->getIdentity());
        $this->assertTrue($acl->isAllowed($resource, 'add-subscriber'));
        $this->assertFalse($acl->isAllowed($resource, 'update-subscription'));


        // registered user rules
        $identity = $this->getRegisteredUser();
        $acl->setIdentity($controller->identity());
        $this->assertEquals($identity, $acl->getIdentity());
        $this->assertTrue($acl->isAllowed($resource, 'add-subscriber'));
        $this->assertTrue($acl->isAllowed($resource, 'update-subscription'));

        // admin user rules
        $identity = $this->getAdminUser();
        $acl->setIdentity($controller->identity());
        $this->assertEquals($identity, $acl->getIdentity());
        $this->assertTrue($acl->isAllowed($resource, 'add-subscriber'));
        $this->assertTrue($acl->isAllowed($resource, 'update-subscription'));
    }

    public function testSubscripberAdminControllerRules()
    {
        $serviceManager = $this->getServiceManager();

        $resource = 'UthandoNewsletter\Controller\SubscriberAdminController';
        $controller = new SubscriberAdmin();
        $controller->setServiceLocator($serviceManager);
        $controller->setPluginManager($serviceManager->get('ControllerPluginManager'));
        /* @var \UthandoUser\Controller\Plugin\IsAllowed $acl */
        $acl = $controller->plugin('isAllowed');

        // guest rules
        $identity = null;
        $acl->setIdentity($identity);
        $this->assertInstanceOf(GenericRole::class, $acl->getIdentity());
        $this->assertFalse($acl->isAllowed($resource, 'index'));
        $this->assertFalse($acl->isAllowed($resource, 'list'));
        $this->assertFalse($acl->isAllowed($resource, 'add'));
        $this->assertFalse($acl->isAllowed($resource, 'edit'));
        $this->assertFalse($acl->isAllowed($resource, 'delete'));


        // registered user rules
        $identity = $this->getRegisteredUser();
        $acl->setIdentity($controller->identity());
        $this->assertEquals($identity, $acl->getIdentity());
        $this->assertFalse($acl->isAllowed($resource, 'index'));
        $this->assertFalse($acl->isAllowed($resource, 'list'));
        $this->assertFalse($acl->isAllowed($resource, 'add'));
        $this->assertFalse($acl->isAllowed($resource, 'edit'));
        $this->assertFalse($acl->isAllowed($resource, 'delete'));

        // admin user rules
        $identity = $this->getAdminUser();
        $acl->setIdentity($controller->identity());
        $this->assertEquals($identity, $acl->getIdentity());
        $this->assertTrue($acl->isAllowed($resource, 'index'));
        $this->assertTrue($acl->isAllowed($resource, 'list'));
        $this->assertTrue($acl->isAllowed($resource, 'add'));
        $this->assertTrue($acl->isAllowed($resource, 'edit'));
        $this->assertTrue($acl->isAllowed($resource, 'delete'));
    }

    public function testTemplateControllerRules()
    {
        $serviceManager = $this->getServiceManager();

        $resource = 'UthandoNewsletter\Controller\Template';
        $controller = new TemplateController();
        $controller->setServiceLocator($serviceManager);
        $controller->setPluginManager($serviceManager->get('ControllerPluginManager'));
        /* @var \UthandoUser\Controller\Plugin\IsAllowed $acl */
        $acl = $controller->plugin('isAllowed');

        // guest rules
        $identity = null;
        $acl->setIdentity($identity);
        $this->assertInstanceOf(GenericRole::class, $acl->getIdentity());
        $this->assertFalse($acl->isAllowed($resource, 'index'));
        $this->assertFalse($acl->isAllowed($resource, 'list'));
        $this->assertFalse($acl->isAllowed($resource, 'add'));
        $this->assertFalse($acl->isAllowed($resource, 'edit'));
        $this->assertFalse($acl->isAllowed($resource, 'delete'));
        $this->assertFalse($acl->isAllowed($resource, 'preview'));


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
    }
}
