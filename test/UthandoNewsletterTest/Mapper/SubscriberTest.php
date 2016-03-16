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

use UthandoNewsletter\Hydrator\Subscriber as SubscriberHydrator;
use UthandoNewsletter\Mapper\Subscriber;
use UthandoNewsletter\Model\Subscriber as SubscriberModel;
use Zend\Db\ResultSet\HydratingResultSet;

class SubscriberTest extends MapperTestCase
{
    public function testCanCreateFromServiceManager()
    {
        /* @var Subscriber $mapper */
        $mapper = $this->serviceManager
            ->get('UthandoMapperManager')
            ->get('UthandoNewsletterSubscriber');

        $this->assertInstanceOf(Subscriber::class, $mapper);
        $this->assertSame('subscriberId', $mapper->getPrimaryKey());
        $this->assertSame('newsletterSubscriber', $mapper->getTable());
    }

    public function testGetByEmail()
    {
        $mapper = new Subscriber();
        $mapper->setDbAdapter($this->mockAdapter);
        $mapper->setHydrator(new SubscriberHydrator());
        $mapper->setModel(new SubscriberModel());

        $this->assertInstanceOf(SubscriberModel::class, $mapper->getByEmail('joe@bloggs.com'));
    }

    public function testGetSubscribersById()
    {
        $mapper = new Subscriber();
        $mapper->setDbAdapter($this->mockAdapter);
        $mapper->setHydrator(new SubscriberHydrator());
        $mapper->setModel(new SubscriberModel());

        $this->assertInstanceOf(HydratingResultSet::class, $mapper->getSubscribersById([1,2,3]));
    }
}
