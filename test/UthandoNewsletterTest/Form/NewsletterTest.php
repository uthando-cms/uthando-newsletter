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

use UthandoNewsletter\Form\Newsletter;
use UthandoNewsletterTest\Framework\TestCase;

class NewsletterTest extends TestCase
{
    public function testCanCreateFromServiceManager()
    {
        $form = $this->serviceManager
            ->get('FormElementManager')
            ->get('UthandoNewsletter');

        $this->assertInstanceOf(Newsletter::class, $form);

        $this->assertTrue($form->has('newsletterId'));
        $this->assertTrue($form->has('name'));
        $this->assertTrue($form->has('description'));
        $this->assertTrue($form->has('visible'));
        $this->assertTrue($form->has('security'));
    }
}
