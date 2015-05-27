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

use UthandoCommon\Service\AbstractRelationalMapperService;

/**
 * Class Message
 *
 * @package UthandoNewsletter\Service
 */
class Message extends AbstractRelationalMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'UthandoNewsletterMessage';

    /**
     * @var array
     */
    protected $referenceMap = [
        'template'      => [
            'refCol'    => 'templateId',
            'service'   => 'UthandoNewsletterTemplate',
        ],
    ];

    /**
     * @param $id
     * @param null $cols
     * @return array|null|\UthandoNewsletter\Model\Message
     */
    public function getById($id, $cols = null)
    {
        $model = parent::getById($id, $cols);

        $this->populate($model, true);

        return $model;
    }
}