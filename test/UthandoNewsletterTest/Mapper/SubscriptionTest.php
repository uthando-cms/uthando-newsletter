<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletterTest\Mapper
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletterTest\Mapper;


use UthandoNewsletter\Hydrator\SubscriptionHydrator as SubscriptionHydrator;
use UthandoNewsletter\Mapper\SubscriptionMapper;
use UthandoNewsletter\Model\SubscriptionModel as SubscriptionModel;
use Zend\Db\ResultSet\HydratingResultSet;

class SubscriptionTest extends MapperTestCase
{
    public function testCanCreateFromServiceManager()
    {
        /* @var SubscriptionMapper $mapper */
        $mapper = $this->serviceManager
            ->get('UthandoMapperManager')
            ->get('UthandoNewsletterSubscription');

        $this->assertInstanceOf(SubscriptionMapper::class, $mapper);
        $this->assertSame('subscriptionId', $mapper->getPrimaryKey());
        $this->assertSame('newsletterSubscription', $mapper->getTable());
    }

    public function testGetSubscriptionsBySubscriberId()
    {
        $mapper = new SubscriptionMapper();
        $mapper->setDbAdapter($this->mockAdapter);
        $mapper->setHydrator(new SubscriptionHydrator());
        $mapper->setModel(new SubscriptionModel());

        $this->assertInstanceOf(HydratingResultSet::class, $mapper->getSubscriptionsBySubscriberId(1));
    }

    public function testGetSubscriptionsByNewsletterId()
    {
        $mapper = new SubscriptionMapper();
        $mapper->setDbAdapter($this->mockAdapter);
        $mapper->setHydrator(new SubscriptionHydrator());
        $mapper->setModel(new SubscriptionModel());

        $this->assertInstanceOf(HydratingResultSet::class, $mapper->getSubscriptionsByNewsletterId(1));
    }
}
