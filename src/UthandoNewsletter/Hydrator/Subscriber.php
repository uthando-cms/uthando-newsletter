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

/**
 * Class Newsletter
 *
 * @package UthandoNewsletter\Hydrator
 */
class Subscriber extends AbstractHydrator
{
    public function __construct()
    {
        parent::__construct();

        $this->addStrategy('dateCreated', new DateTimeStrategy());
    }
    /**
     * @param \UthandoNewsletter\Model\Subscriber $object
     * @return array
     */
    public function extract($object)
    {
        return [
            'subscriberId'  => $object->getSubscriberId(),
            'name'          => $object->getName(),
            'email'         => $object->getEmail(),
            'dateCreated'   => $this->extractValue('dateCreated', $object->getDateCreated()),
        ];
    }
}