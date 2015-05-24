<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\Controller
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace UthandoNewsletter\Controller;

use UthandoCommon\Controller\AbstractCrudController;

/**
 * Class Template
 *
 * @package UthandoNewsletter\Controller
 */
class Template extends AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'templateId'];
    protected $serviceName = 'UthandoNewsletterTemplate';
    protected $route = 'admin/newsletter/template';
}