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

use Zend\Form\Form;

/**
 * Class Newsletter
 *
 * @package UthandoNewsletter\Form
 */
class Subscriber extends Form
{
    public function init()
    {
        $this->add([
            'name' => 'subscriberId',
            'type' => 'hidden',
        ]);

        $this->add([
            'name' => 'email',
            'type' => 'email',
            'options' => [
                'label' => 'Email Address',
            ],
        ]);
    }
}