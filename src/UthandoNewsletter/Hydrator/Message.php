<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\Hydrator
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletter\Hydrator;

use UthandoCommon\Hydrator\AbstractHydrator;

/**
 * Class Message
 *
 * @package UthandoNewsletter\Hydrator
 */
class Message extends AbstractHydrator
{
    /**
     * @param \UthandoNewsletter\Model\Message $object
     * @return array
     */
    public function extract($object)
    {
        return [
            'messageId'     => $object->getMessageId(),
            'newsletterId'  => $object->getNewsletterId(),
            'templateId'    => $object->getTemplateId(),
            'subject'       => $object->getSubject(),
            'params'        => $object->getParams(),
            'message'       => $object->getMessage(),
        ];
    }
}