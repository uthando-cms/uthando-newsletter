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

use UthandoNewsletter\Form\Preferences;
use UthandoNewsletterTest\Framework\TestCase;

class PreferencesTest extends TestCase
{
    public function testCanCreateFormServiceManager()
    {
        $form = $this->serviceManager
            ->get('FormElementManager')
            ->get('UthandoNewsletterPreferences');

        $this->assertInstanceOf(Preferences::class, $form);

        $this->assertTrue($form->has('email'));
        $this->assertTrue($form->has('captcha'));
        $this->assertTrue($form->has('submit'));
        $this->assertTrue($form->has('security'));
    }
}
