<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletterTest\Hydrator
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletterTest\Hydrator;

use UthandoNewsletter\Hydrator\Subscription;
use UthandoNewsletter\Model\Subscription as SubscriptionModel;
use UthandoNewsletterTest\Framework\TestCase;

class SubscriptionTest extends TestCase
{
    public function testCanGetFromServiceManager()
    {
        $hydrator = $this->serviceManager
            ->get('HydratorManager')
            ->get('UthandoNewsletterSubscription');
        $this->assertInstanceOf(Subscription::class, $hydrator);
    }

    public function testExtract()
    {
        $data = [
            'subscriptionId'    => 1,
            'newsletterId'      => 1,
            'subscriberId'      => 1,
        ];

        $hydrator = new Subscription();
        $model = $hydrator->hydrate($data, new SubscriptionModel());
        $this->assertSame($data, $hydrator->extract($model));
    }
}
