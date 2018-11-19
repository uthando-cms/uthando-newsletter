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

use UthandoNewsletter\Form\PreferencesForm as PreferencesForm;
use UthandoNewsletter\Mvc\Controller\PreferencesController;
use UthandoNewsletter\Service\SubscriberService;
use UthandoNewsletterTest\Framework\ApplicationTestCase;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Controller\Plugin\PostRedirectGet;

class PreferencesTest extends ApplicationTestCase
{
    public function testIndexActionCanBeAccessed()
    {
        $this->dispatch('/newsletter');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('UthandoNewsletter');
        $this->assertControllerName('UthandoNewsletter\Controller\Preferences');
        $this->assertControllerClass('Preferences');
        $this->assertMatchedRouteName('newsletter');
    }

    public function testIndexActionReturnsResponseOnPost()
    {
        $postData = [
            'email' => 'joe@bloggs.com',
        ];

        $this->dispatch('/newsletter', 'POST', $postData);

        $this->assertInstanceOf(Response::class, $this->getResponse());
        $this->assertResponseStatusCode(303);

        $this->assertRedirectTo('/newsletter');
    }

    public function testIndexActionReturnsFormOnError()
    {
        $postData = [
            'email' => 'joe@bloggs.com',
        ];

        $messageServiceMock = $this->getMock(SubscriberService::class);
        $messageServiceMock->method('getForm')->willReturn(new PreferencesForm());
        $messageServiceMock->method('removeSubscriberFromList')->willReturn(new PreferencesForm());

        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);
        $serviceManager->get('UthandoServiceManager')->setService('UthandoNewsletterSubscriber', $messageServiceMock);

        $oPrg = $this->getMock(PostRedirectGet::class);
        $oPrg->expects($this->any())->method('__invoke')->willReturn($postData);
        $pluginManager = $serviceManager->get('ControllerPluginManager');
        $pluginManager->setService('prg', $oPrg);

        $controller = new PreferencesController();
        $controller->setServiceLocator($serviceManager);
        $controller->setPluginManager($pluginManager);

        $result = $controller->indexAction();
        $this->assertArrayHasKey('form', $result);
        $this->assertInstanceOf(PreferencesForm::class, $result['form']);
    }

    public function testIndexActionReturnsTrueOnSuccess()
    {
        $postData = [
            'email' => 'joe@bloggs.com',
        ];

        $messageServiceMock = $this->getMock(SubscriberService::class);
        $messageServiceMock->method('getForm')->willReturn(new PreferencesForm());
        $messageServiceMock->method('removeSubscriberFromList')->willReturn(1);

        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);
        $serviceManager->get('UthandoServiceManager')->setService('UthandoNewsletterSubscriber', $messageServiceMock);

        $oPrg = $this->getMock(PostRedirectGet::class);
        $oPrg->expects($this->any())->method('__invoke')->willReturn($postData);
        $pluginManager = $serviceManager->get('ControllerPluginManager');
        $pluginManager->setService('prg', $oPrg);

        $controller = new PreferencesController();
        $controller->setServiceLocator($serviceManager);
        $controller->setPluginManager($pluginManager);

        $result = $controller->indexAction();
        $this->assertEquals(1, $result['result']);
    }
}
