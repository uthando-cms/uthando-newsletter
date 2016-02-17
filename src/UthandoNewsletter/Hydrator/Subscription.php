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
use UthandoNewsletter\Model\Subscription as SubscriptionModel;

/**
 * Class Subscription
 *
 * @package UthandoNewsletter\Hydrator
 */
class Subscription extends AbstractHydrator
{
    /**
     * @param SubscriptionModel $object
     * @return array
     */
    public function extract($object)
    {
        return [
            'subscriptionId'    => $object->getSubscriptionId(),
            'newsletterId'      => $object->getNewsletterId(),
            'subscriberId'      => $object->getSubscriberId(),
        ];
    }
}