<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\Form
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace UthandoNewsletter\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Form\Form;

/**
 * Class Message
 *
 * @package UthandoNewsletter\Form
 */
class Message extends Form
{
    public function init()
    {
        $this->add([
            'name' => 'messageId',
            'type' => 'hidden',
        ]);

        $this->add([
            'name' => 'templateId',
            'type' => 'UthandoNewsletterTemplateList',
            'options' => [
                'label' => 'Template',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-4',
                'label_attributes' => [
                    'class' => 'col-md-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'subject',
            'type' => 'text',
            'options' => [
                'label' => 'Subject',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-4',
                'label_attributes' => [
                    'class' => 'col-md-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'params',
            'type' => 'textarea',
            'options' => [
                'label' => 'Params',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-10',
                'label_attributes' => [
                    'class' => 'col-md-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'message',
            'type' => 'textarea',
            'options' => [
                'label' => 'Body',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-10',
                'label_attributes' => [
                    'class' => 'col-md-2',
                ],
            ],
            'attributes' => [
                'rows' => 25,
            ],
        ]);
    }
}