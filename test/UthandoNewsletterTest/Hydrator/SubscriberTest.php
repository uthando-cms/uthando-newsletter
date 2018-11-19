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

use UthandoCommon\Hydrator\Strategy\DateTime;
use UthandoNewsletter\Hydrator\SubscriberHydrator;
use UthandoNewsletter\Model\SubscriberModel as SubscriberModel;
use UthandoNewsletterTest\Framework\TestCase;

class SubscriberTest extends TestCase
{
    public function testCanGetFromServiceManager()
    {
        $hydrator = $this->serviceManager
            ->get('HydratorManager')
            ->get('UthandoNewsletterSubscriber');
        $this->assertInstanceOf(SubscriberHydrator::class, $hydrator);
    }

    public function testHydratorHasCorrectStrategiesSet()
    {
        $hydrator = new SubscriberHydrator();
        
        $this->assertTrue($hydrator->hasStrategy('dateCreated'));
        $this->assertInstanceOf(DateTime::class, $hydrator->getStrategy('dateCreated'));
    }

    public function testExtract()
    {
        $data = [
            'subscriberId'  => 1,
            'name'          => 'Joe Bloggs',
            'email'         => 'joe@blogs.com',
            'dateCreated'   => '2016-02-19 18:12:21',
        ];

        $hydrator = new SubscriberHydrator();
        $model = $hydrator->hydrate($data, new SubscriberModel());
        $this->assertSame($data, $hydrator->extract($model));
    }
}
