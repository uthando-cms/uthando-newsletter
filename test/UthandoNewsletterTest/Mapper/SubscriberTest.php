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

use UthandoNewsletter\Hydrator\SubscriberHydrator as SubscriberHydrator;
use UthandoNewsletter\Mapper\SubscriberMapper;
use UthandoNewsletter\Model\SubscriberModel as SubscriberModel;
use Zend\Db\ResultSet\HydratingResultSet;

class SubscriberTest extends MapperTestCase
{
    public function testCanCreateFromServiceManager()
    {
        /* @var SubscriberMapper $mapper */
        $mapper = $this->serviceManager
            ->get('UthandoMapperManager')
            ->get('UthandoNewsletterSubscriber');

        $this->assertInstanceOf(SubscriberMapper::class, $mapper);
        $this->assertSame('subscriberId', $mapper->getPrimaryKey());
        $this->assertSame('newsletterSubscriber', $mapper->getTable());
    }

    public function testGetByEmail()
    {
        $mapper = new SubscriberMapper();
        $mapper->setDbAdapter($this->mockAdapter);
        $mapper->setHydrator(new SubscriberHydrator());
        $mapper->setModel(new SubscriberModel());

        $this->assertInstanceOf(SubscriberModel::class, $mapper->getByEmail('joe@bloggs.com'));
    }

    public function testGetSubscribersById()
    {
        $mapper = new SubscriberMapper();
        $mapper->setDbAdapter($this->mockAdapter);
        $mapper->setHydrator(new SubscriberHydrator());
        $mapper->setModel(new SubscriberModel());

        $this->assertInstanceOf(HydratingResultSet::class, $mapper->getSubscribersById([1,2,3]));
    }
}
