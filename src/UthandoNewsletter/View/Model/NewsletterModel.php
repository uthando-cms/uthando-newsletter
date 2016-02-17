<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\View\Model
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletter\View\Model;

use Zend\View\Model\ViewModel;

/**
 * Class NewsletterModel
 *
 * @package UthandoNewsletter\View\Model
 */
class NewsletterModel extends ViewModel
{
    /**
     * Newsletter probably won't need to be captured into a
     * a parent container by default.
     *
     * @var string
     */
    protected $captureTo = null;

    /**
     * Newsletter is usually terminal
     *
     * @var bool
     */
    protected $terminate = true;
}