<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\Form
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletter\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use UthandoNewsletter\Form\Element\NewsletterList;
use UthandoNewsletter\Form\Element\TemplateList;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;

/**
 * Class Message
 *
 * @package UthandoNewsletter\Form
 */
class MessageForm extends Form
{
    public function init()
    {
        $this->add([
            'name' => 'messageId',
            'type' => Hidden::class,
        ]);

        $this->add([
            'name' => 'newsletterId',
            'type' => NewsletterList::class,
            'options' => [
                'label' => 'Newsletter',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'templateId',
            'type' => TemplateList::class,
            'options' => [
                'label' => 'Template',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'subject',
            'type' => Text::class,
            'options' => [
                'label' => 'Subject',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'params',
            'type' => Textarea::class,
            'options' => [
                'label' => 'Params',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'message',
            'type' => Textarea::class,
            'options' => [
                'label' => 'Body',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
            'attributes' => [
                'class' => 'editable-textarea',
                'rows' => 25,
            ],
        ]);

        $this->add([
            'name' => 'security',
            'type' => Csrf::class,
        ]);
    }
}