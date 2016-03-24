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

use UthandoNewsletter\Hydrator\Newsletter as NewsletterHydrator;
use UthandoNewsletter\Mapper\Newsletter;
use UthandoNewsletter\Model\Newsletter as NewsletterModel;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Select;

class NewsletterTest extends MapperTestCase
{
    public function testCanCreateFromServiceManager()
    {
        /* @var Newsletter $mapper */
        $mapper = $this->serviceManager
            ->get('UthandoMapperManager')
            ->get('UthandoNewsletter');

        $this->assertInstanceOf(Newsletter::class, $mapper);
        $this->assertSame('newsletterId', $mapper->getPrimaryKey());
        $this->assertSame('newsletter', $mapper->getTable());
    }

    public function testFetchAllVisible()
    {
        $mapper = new Newsletter();
        $mapper->setDbAdapter($this->mockAdapter);
        $mapper->setHydrator(new NewsletterHydrator());
        $mapper->setModel(new NewsletterModel());

        $result = $mapper->fetchAllVisible();

        $this->assertInstanceOf(HydratingResultSet::class, $result);
    }
}
