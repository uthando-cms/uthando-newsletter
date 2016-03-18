<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletterTest\Mvc\Service
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletterTest\Mvc\Service;

use UthandoNewsletter\Mvc\Service\ViewNewsletterRendererFactory;
use UthandoNewsletter\Service\Message;
use UthandoNewsletter\Service\Template;
use UthandoNewsletter\View\Renderer\NewsletterEngine;
use UthandoNewsletter\View\Renderer\NewsletterRenderer;
use UthandoNewsletter\View\Resolver\NewsletterResolver;
use UthandoNewsletterTest\Framework\TestCase;
use Zend\View\Helper\Url;

class ViewNewsletterRendererFactoryTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $urlHelperMock = $this->getMock('Zend\View\Helper\Url');
        $this->serviceManager->get('ViewHelperManager')->setAllowOverride(true);
        $this->serviceManager->get('ViewHelperManager')->setService('url', $urlHelperMock);
    }

    public function testCanGetFromServiceManager()
    {
        $service = $this->serviceManager->get('ViewNewsletterRenderer');
        $this->assertInstanceOf(NewsletterRenderer::class, $service);
    }

    public function testCreateService()
    {
        $factory = new ViewNewsletterRendererFactory();
        $service = $factory->createService($this->serviceManager);

        $this->assertInstanceOf(NewsletterRenderer::class, $service);

        // test dependencies are set.
        $this->assertInstanceOf(NewsletterResolver::class, $service->resolver());
        $this->assertInstanceOf(NewsletterEngine::class, $service->getEngine());

        $this->assertInstanceOf(Url::class, $service->getEngine()->getUrlHelper());
        $this->assertInstanceOf(Template::class, $service->resolver()->getTemplateService());
        $this->assertInstanceOf(Message::class, $service->resolver()->getMessageService());
    }
}
