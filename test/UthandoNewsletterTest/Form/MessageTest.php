<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletterTest\Form
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletterTest\Form;

use UthandoNewsletter\Form\Message;
use UthandoNewsletterTest\Framework\TestCase;

class MessageTest extends TestCase
{
    public function testCanCreateFormServiceManager()
    {
       $form = $this->serviceManager
            ->get('FormElementManager')
            ->get('UthandoNewsletterMessage');

        $this->assertInstanceOf(Message::class, $form);

        $this->assertTrue($form->has('messageId'));
        $this->assertTrue($form->has('newsletterId'));
        $this->assertTrue($form->has('templateId'));
        $this->assertTrue($form->has('subject'));
        $this->assertTrue($form->has('params'));
        $this->assertTrue($form->has('message'));
        $this->assertTrue($form->has('security'));
    }
}
