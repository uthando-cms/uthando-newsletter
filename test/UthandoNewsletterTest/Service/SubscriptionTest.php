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

use UthandoNewsletter\Model\Subscription as SubscriptionModel;
use UthandoNewsletter\Service\Subscription;
use UthandoNewsletterTest\Framework\TestCase;

class SubscriptionTest extends TestCase
{
    public function testCanGetFromServiceManager()
    {
        $service = $this->serviceManager
            ->get('UthandoServiceManager')
            ->get('UthandoNewsletterSubscription');

        $this->assertInstanceOf(Subscription::class, $service);
    }

    public function testGetSubscriptionsBySubscriberId()
    {
        $subscriptionModel = new SubscriptionModel();

        $subscriptionMapperMock = $this->getMock('UthandoNewsletter\Mapper\Subscription');
        $subscriptionMapperMock->expects($this->once())
            ->method('getSubscriptionsBySubscriberId')
            ->willReturn([$subscriptionModel]);

        $this->serviceManager->get('UthandoMapperManager')->setAllowOverride(true);
        $this->serviceManager->get('UthandoMapperManager')->setService('UthandoNewsletterSubscription', $subscriptionMapperMock);

        /* @var Subscription $service */
        $service = $this->serviceManager
            ->get('UthandoServiceManager')
            ->get('UthandoNewsletterSubscription');
        $result = $service->getSubscriptionsBySubscriberId(1);

        $this->assertEquals(true, is_array($result));
        $this->assertEquals(1, count($result));
        
        foreach ($result as $model) {
            $this->assertInstanceOf(SubscriptionModel::class, $model);
        }
    }
}
