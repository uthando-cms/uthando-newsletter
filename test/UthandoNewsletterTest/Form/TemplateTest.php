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


use UthandoNewsletter\Form\TemplateForm;
use UthandoNewsletterTest\Framework\TestCase;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;

class TemplateTest extends TestCase
{
    public function testCanCreateFromServiceManager()
    {
        $form = $this->serviceManager
            ->get('FormElementManager')
            ->get('UthandoNewsletterTemplate');

        $this->assertInstanceOf(TemplateForm::class, $form);

        $this->assertInstanceOf(Hidden::class, $form->get('templateId'));
        $this->assertInstanceOf(Text::class, $form->get('name'));
        $this->assertInstanceOf(Textarea::class, $form->get('params'));
        $this->assertInstanceOf(Textarea::class, $form->get('body'));
        $this->assertInstanceOf(Csrf::class, $form->get('security'));
    }
}
