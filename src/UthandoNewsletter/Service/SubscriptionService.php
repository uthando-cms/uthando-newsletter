<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\Service
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletter\Service;


use UthandoCommon\Service\AbstractMapperService;
use UthandoNewsletter\Hydrator\SubscriptionHydrator;
use UthandoNewsletter\Mapper\SubscriptionMapper;
use UthandoNewsletter\Model\SubscriptionModel;

/**
 * Class Subscription
 *
 * @package UthandoNewsletter\Service
 * @method SubscriptionMapper getMapper($mapperClass = null, array $options = [])
 */
class SubscriptionService extends AbstractMapperService
{
    protected $hydrator     = SubscriptionHydrator::class;
    protected $mapper       = SubscriptionMapper::class;
    protected $model        = SubscriptionModel::class;

    /**
     * @param $id
     * @return array
     */
    public function getSubscriptionsBySubscriberId($id)
    {
        $id = (int) $id;

        $subscriptions = $this->getMapper()->getSubscriptionsBySubscriberId($id);

        $newsletterSubscriptions = [];

        foreach ($subscriptions as $subscription) {
            $newsletterSubscriptions[] = $subscription;
        }

        return $newsletterSubscriptions;
    }
}