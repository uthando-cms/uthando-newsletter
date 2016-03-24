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

use UthandoNewsletter\Form\Element\NewsletterList;
use UthandoNewsletter\Form\Element\TemplateList;
use UthandoNewsletter\Form\Message;
use UthandoNewsletterTest\Framework\TestCase;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;

class MessageTest extends TestCase
{
    public function testCanCreateFormServiceManager()
    {
       $form = $this->serviceManager
            ->get('FormElementManager')
            ->get('UthandoNewsletterMessage');

        $this->assertInstanceOf(Message::class, $form);

        $this->assertInstanceOf(Hidden::class, $form->get('messageId'));
        $this->assertInstanceOf(NewsletterList::class, $form->get('newsletterId'));
        $this->assertInstanceOf(TemplateList::class, $form->get('templateId'));
        $this->assertInstanceOf(Text::class, $form->get('subject'));
        $this->assertInstanceOf(Textarea::class, $form->get('params'));
        $this->assertInstanceOf(Textarea::class, $form->get('message'));
        $this->assertInstanceOf(Csrf::class, $form->get('security'));
    }
}
