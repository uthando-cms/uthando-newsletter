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
use UthandoCommon\Hydrator\Strategy\DateTime as DateTimeStrategy;
use UthandoCommon\Hydrator\Strategy\TrueFalse;

/**
 * Class Message
 *
 * @package UthandoNewsletter\Hydrator
 */
class Message extends AbstractHydrator
{
    public function __construct()
    {
        parent::__construct();

        $dateTime = new DateTimeStrategy();
        $this->addStrategy('sent', new TrueFalse());
        $this->addStrategy('dateCreated', $dateTime);
        $this->addStrategy('dateSent', $dateTime);
    }

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
            'sent'          => $this->extractValue('sent', $object->isSent()),
            'dateCreated'   => $this->extractValue('dateCreated', $object->getDateCreated()),
            'dateSent'      => $this->extractValue('dateSent', $object->getDateSent()),
        ];
    }
}