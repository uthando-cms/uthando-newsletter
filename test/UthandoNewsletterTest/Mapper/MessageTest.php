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

use UthandoNewsletter\Mapper\MessageMapper;

class MessageTest extends MapperTestCase
{
    public function testCanCreateFromServiceManager()
    {
        /* @var MessageMapper $mapper */
        $mapper = $this->serviceManager
            ->get('UthandoMapperManager')
            ->get('UthandoNewsletterMessage');

        $this->assertInstanceOf(MessageMapper::class, $mapper);
    }

    public function testHasPrimaryKeySet()
    {
        $pk = 'messageId';
        $mapper = new MessageMapper();

        $this->assertEquals($pk, $mapper->getPrimaryKey());
    }

    public function testHasTableNameSet()
    {
        $table = 'newsletterMessage';
        $mapper = new MessageMapper();

        $this->assertEquals($table, $mapper->getTable());
    }
}
