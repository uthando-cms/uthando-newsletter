<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletterTest\InputFilter
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletterTest\InputFilter;

use UthandoNewsletter\InputFilter\Message;
use UthandoNewsletterTest\Framework\TestCase;

class MessageTest extends TestCase
{
    public function testCanGetFromServiceManager()
    {
        /* @var Message $inputFilter */
        $inputFilter = $this->serviceManager
            ->get('InputFilterManager')
            ->get('UthandoNewsletterMessage');
        $this->assertInstanceOf(Message::class, $inputFilter);

        $this->assertTrue($inputFilter->has('messageId'));
        $this->assertTrue($inputFilter->has('newsletterId'));
        $this->assertTrue($inputFilter->has('templateId'));
        $this->assertTrue($inputFilter->has('subject'));
        $this->assertTrue($inputFilter->has('params'));
        $this->assertTrue($inputFilter->has('message'));

        $this->assertEquals(6, $inputFilter->count());
    }
}
