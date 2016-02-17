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

/**
 * Class Subscription
 *
 * @package UthandoNewsletter\Service
 * @method \UthandoNewsletter\Mapper\Subscription getMapper($mapperClass = null, array $options = [])
 */
class Subscription extends AbstractMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'UthandoNewsletterSubscription';

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