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

use UthandoNewsletter\Form\NewsletterForm;
use UthandoNewsletterTest\Framework\TestCase;
use Zend\Form\Element\Checkbox;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Text;

class NewsletterTest extends TestCase
{
    public function testCanCreateFromServiceManager()
    {
        $form = $this->serviceManager
            ->get('FormElementManager')
            ->get('UthandoNewsletter');

        $this->assertInstanceOf(NewsletterForm::class, $form);

        $this->assertInstanceOf(Hidden::class, $form->get('newsletterId'));
        $this->assertInstanceOf(Text::class, $form->get('name'));
        $this->assertInstanceOf(Text::class, $form->get('description'));
        $this->assertInstanceOf(Checkbox::class, $form->get('visible'));
        $this->assertInstanceOf(Csrf::class, $form->get('security'));
    }
}
