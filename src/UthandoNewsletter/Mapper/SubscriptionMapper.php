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

/**
 * Class Subscription
 *
 * @package UthandoNewsletter\Mapper
 */
class SubscriptionMapper extends AbstractDbMapper
{
    protected $table = 'newsletterSubscription';
    protected $primary = 'subscriptionId';

    /**
     * @param $id
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function getSubscriptionsBySubscriberId($id)
    {
        $select = $this->getSelect();
        $select->where->equalTo('subscriberId', $id);

        $rowSet = $this->fetchResult($select);
        return $rowSet;
    }

    /**
     * @param $id
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function getSubscriptionsByNewsletterId($id)
    {
        $select = $this->getSelect();
        $select->where->equalTo('newsletterId', $id);

        $rowSet = $this->fetchResult($select);

        return $rowSet;
    }
}