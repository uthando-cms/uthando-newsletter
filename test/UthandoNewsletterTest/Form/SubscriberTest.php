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

use UthandoNewsletter\Form\Element\SubscriptionList;
use UthandoNewsletter\Form\Subscriber;
use UthandoNewsletterTest\Framework\TestCase;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\DateTime;
use Zend\Form\Element\Email;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Text;

class SubscriberTest extends TestCase
{
    public function testCanCreateFromServiceManager()
    {
        $form = $this->serviceManager
            ->get('FormElementManager')
            ->get('UthandoNewsletterSubscriber');

        $this->assertInstanceOf(Subscriber::class, $form);

        $this->assertInstanceOf(Hidden::class, $form->get('subscriberId'));
        $this->assertInstanceOf(Text::class, $form->get('name'));
        $this->assertInstanceOf(Email::class, $form->get('email'));
        $this->assertInstanceOf(SubscriptionList::class, $form->get('subscribe'));
        $this->assertInstanceOf(DateTime::class, $form->get('dateCreated'));
        $this->assertInstanceOf(Csrf::class, $form->get('security'));
    }

    public function testCanUseNameAsOptions()
    {
        $form = new Subscriber(['name' => 'subscriber']);

        $this->assertSame('subscriber', $form->getName());
    }
}
