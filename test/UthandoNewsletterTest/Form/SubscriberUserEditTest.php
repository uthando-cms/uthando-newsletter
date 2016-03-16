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

use UthandoNewsletter\Form\SubscriberUserEdit;
use UthandoNewsletterTest\Framework\TestCase;

class SubscriberUserEditTest extends TestCase
{
    public function testCanCreateFromServiceManager()
    {
        $form = $this->serviceManager
            ->get('FormElementManager')
            ->get('UthandoNewsletterSubscriberUserEdit');

        $this->assertInstanceOf(SubscriberUserEdit::class, $form);

        $this->assertTrue($form->has('subscriberId'));
        $this->assertTrue($form->has('name'));
        $this->assertTrue($form->has('email'));
        $this->assertTrue($form->has('subscribe'));
        $this->assertTrue($form->has('dateCreated'));
        $this->assertTrue($form->has('security'));
        $this->assertTrue($form->has('submit'));
    }
}
