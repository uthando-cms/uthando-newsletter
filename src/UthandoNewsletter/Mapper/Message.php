<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\Mapper
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace UthandoNewsletter\Mapper;

use UthandoCommon\Mapper\AbstractDbMapper;

/**
 * Class Message
 *
 * @package UthandoNewsletter\Mapper
 */
class Message extends AbstractDbMapper
{
    protected $table = 'newsletterMessage';
    protected $primary = 'messageId';
}