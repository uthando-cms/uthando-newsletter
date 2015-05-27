<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\Service
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace UthandoNewsletter\Service;

use UthandoCommon\Service\AbstractMapperService;

/**
 * Class Template
 *
 * @package UthandoNewsletter\Service
 * @method \UthandoNewsletter\Model\Template|array|null getById($id, $col = null)
 */
class Template extends AbstractMapperService
{
    protected $serviceAlias = 'UthandoNewsletterTemplate';
}