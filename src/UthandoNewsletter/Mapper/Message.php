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
use Zend\Db\Sql\Select;

/**
 * Class Message
 *
 * @package UthandoNewsletter\Mapper
 */
class Message extends AbstractDbMapper
{
    protected $table = 'newsletterMessage';
    protected $primary = 'messageId';

    public function search(array $search, $sort, $select = null)
    {
        $select = $this->getSelect();

        $sort = str_replace('_', '.', $sort);

        $select->join(
            'newsletter',
            'newsletter.newsletterId=newsletterMessage.newsletterId',
            [],
            Select::JOIN_LEFT
        )->join(
            'newsletterTemplate',
            'newsletterTemplate.templateId=newsletterMessage.templateId',
            [],
            Select::JOIN_LEFT
        );

        return parent::search($search, $sort, $select);
    }
}