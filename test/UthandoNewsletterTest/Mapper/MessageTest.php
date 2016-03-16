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

use UthandoNewsletter\Mapper\Message;

class MessageTest extends MapperTestCase
{
    public function testCanCreateFromServiceManager()
    {
        /* @var Message $mapper */
        $mapper = $this->serviceManager
            ->get('UthandoMapperManager')
            ->get('UthandoNewsletterMessage');

        $this->assertInstanceOf(Message::class, $mapper);
        $this->assertSame('messageId', $mapper->getPrimaryKey());
        $this->assertSame('newsletterMessage', $mapper->getTable());
    }
}
