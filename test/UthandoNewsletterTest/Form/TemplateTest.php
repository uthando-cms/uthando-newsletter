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


use UthandoNewsletter\Form\Template;
use UthandoNewsletterTest\Framework\TestCase;

class TemplateTest extends TestCase
{
    public function testCanCreateFromServiceManager()
    {
        $form = $this->serviceManager
            ->get('FormElementManager')
            ->get('UthandoNewsletterTemplate');

        $this->assertInstanceOf(Template::class, $form);

        $this->assertTrue($form->has('templateId'));
        $this->assertTrue($form->has('name'));
        $this->assertTrue($form->has('params'));
        $this->assertTrue($form->has('body'));
        $this->assertTrue($form->has('security'));
    }
}
