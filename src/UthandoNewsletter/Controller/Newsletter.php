<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace UthandoNewsletter;

use UthandoCommon\Controller\AbstractCrudController;

/**
 * Class Newsletter
 *
 * @package UthandoNewsletter
 */
class Newsletter extends AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'newsletterId'];
    protected $serviceName = 'UthandoNewsletter';
    protected $route = 'admin/newsletter';

}