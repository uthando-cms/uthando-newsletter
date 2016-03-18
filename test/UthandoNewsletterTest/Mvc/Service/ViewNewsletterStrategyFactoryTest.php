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

use UthandoNewsletter\Mvc\Service\ViewNewsletterStrategyFactory;
use UthandoNewsletter\View\Strategy\NewsletterStrategy;
use UthandoNewsletterTest\Framework\TestCase;

class ViewNewsletterStrategyFactoryTest extends TestCase
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
        $service = $this->serviceManager->get('ViewNewsletterStrategy');
        $this->assertInstanceOf(NewsletterStrategy::class, $service);
    }

    public function testCreateService()
    {
        $factory = new ViewNewsletterStrategyFactory();
        $service = $factory->createService($this->serviceManager);

        $this->assertInstanceOf(NewsletterStrategy::class, $service);
    }
}
