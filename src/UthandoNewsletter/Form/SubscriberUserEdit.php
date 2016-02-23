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
 * Class SubscriberUserEdit
 *
 * @package UthandoNewsletter\Form
 */
class SubscriberUserEdit extends Subscriber
{
    public function init()
    {
        parent::init();

        $this->get('name')->setAttribute('readonly', true);
        $this->get('email')->setAttribute('readonly', true);
        $this->get('subscribe')->setIncludeHidden(false);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'options' => [
                'label' => 'Update',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10 col-sm-offset-2',
            ],
        ]);
    }
}
