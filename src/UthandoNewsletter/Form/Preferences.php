<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\Form
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletter\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;

/**
 * Class Preferences
 *
 * @package UthandoNewsletter\Form
 */
class Preferences extends Subscriber
{
    public function init()
    {
        parent::init();

        $this->remove('subscriberId')
            ->remove('dateCreated')
            ->remove('name')
            ->remove('subscribe');

        $this->add([
            'name' => 'captcha',
            'type' => 'UthandoCommonCaptcha',
            'attributes' => [
                'placeholder' => 'Type letters and number here',
            ],
            'options' => [
                'label' => 'Please verify you are human.',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10 col-sm-offset-2',
                'label_attributes' => [
                    'class' => 'col-sm-10 col-sm-offset-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'options' => [
                'label' => 'Remove Email',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10 col-sm-offset-2',
            ],
        ]);

    }
}
