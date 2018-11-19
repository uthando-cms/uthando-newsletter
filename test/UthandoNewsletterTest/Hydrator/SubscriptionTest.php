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

use UthandoNewsletter\Hydrator\SubscriptionHydrator;
use UthandoNewsletter\Model\SubscriptionModel as SubscriptionModel;
use UthandoNewsletterTest\Framework\TestCase;

class SubscriptionTest extends TestCase
{
    public function testCanGetFromServiceManager()
    {
        $hydrator = $this->serviceManager
            ->get('HydratorManager')
            ->get('UthandoNewsletterSubscription');
        $this->assertInstanceOf(SubscriptionHydrator::class, $hydrator);
    }

    public function testExtract()
    {
        $data = [
            'subscriptionId'    => 1,
            'newsletterId'      => 1,
            'subscriberId'      => 1,
        ];

        $hydrator = new SubscriptionHydrator();
        $model = $hydrator->hydrate($data, new SubscriptionModel());
        $this->assertSame($data, $hydrator->extract($model));
    }
}
