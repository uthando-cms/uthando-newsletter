<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   ${NAMESPACE}
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletter\Model;

use UthandoCommon\Model\DateCreatedTrait;
use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;

/**
 * Class Newsletter
 *
 * @package UthandoNewsletter\Model
 */
class SubscriberModel implements ModelInterface
{
    use Model,
        DateCreatedTrait;

    /**
     * @var int
     */
    protected $subscriberId;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var array
     */
    protected $subscriptions = [];

    /**
     * @var array
     */
    protected $subscribe = [];

    /**
     * @return int
     */
    public function getSubscriberId()
    {
        return $this->subscriberId;
    }

    /**
     * @param int $subscriberId
     * @return $this
     */
    public function setSubscriberId($subscriberId)
    {
        $this->subscriberId = $subscriberId;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param null|int $newsletterId
     * @return array|null|SubscriptionModel
     */
    public function getSubscriptions($newsletterId = null)
    {
        $subscriptionOrSubscriptions = null;

        if (is_scalar($newsletterId)) {
            /* @var $subscription \UthandoNewsletter\Model\SubscriptionModel */
            foreach ($this->subscriptions as $subscription) {
                if ($newsletterId == $subscription->getNewsletterId()) {
                    $subscriptionOrSubscriptions = $subscription;
                    break;
                }
            }
        } else {
            $subscriptionOrSubscriptions = $this->subscriptions;
        }

        return $subscriptionOrSubscriptions;
    }

    /**
     * @param array $subscriptions
     * @return $this
     */
    public function setSubscriptions($subscriptions)
    {
        if ($subscriptions instanceof SubscriptionModel) {
            $subscriptions = [$subscriptions];
        }

        $this->subscriptions = $subscriptions;

        return $this;
    }

    /**
     * @return array
     */
    public function getSubscribe()
    {
        return $this->subscribe;
    }

    /**
     * @param array $subscribe
     * @return $this
     */
    public function setSubscribe(array $subscribe)
    {
        $this->subscribe = $subscribe;
        return $this;
    }
}