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

use UthandoCommon\Form\Element\Captcha;
use UthandoNewsletter\Form\Preferences;
use UthandoNewsletterTest\Framework\TestCase;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Email;
use Zend\Form\Element\Submit;

class PreferencesTest extends TestCase
{
    public function testCanCreateFormServiceManager()
    {
        $form = $this->serviceManager
            ->get('FormElementManager')
            ->get('UthandoNewsletterPreferences');

        $this->assertInstanceOf(Preferences::class, $form);

        $this->assertInstanceOf(Email::class, $form->get('email'));
        $this->assertInstanceOf(Captcha::class, $form->get('captcha'));
        $this->assertInstanceOf(Submit::class, $form->get('submit'));
        $this->assertInstanceOf(Csrf::class, $form->get('security'));
    }
}
