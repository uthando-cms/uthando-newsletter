<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\Mapper
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletter\Mapper;

use UthandoCommon\Mapper\AbstractDbMapper;

/**
 * Class Template
 *
 * @package UthandoNewsletter\Mapper
 */
class TemplateMapper extends AbstractDbMapper
{
    protected $table = 'newsletterTemplate';
    protected $primary = 'templateId';
}