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
 * Class Newsletter
 *
 * @package UthandoNewsletter\Mapper
 */
class SubscriberMapper extends AbstractDbMapper
{
    protected $table = 'newsletterSubscriber';
    protected $primary = 'subscriberId';

    /**
     * @param $email
     * @return array|\UthandoCommon\Model\ModelInterface
     */
    public function getByEmail($email)
    {
        return $this->getById($email, 'email');
    }

    /**
     * @param array $ids
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function getSubscribersById(array $ids)
    {
        $select = $this->getSelect();
        $select->where->in('subscriberId', $ids);

        $rowSet = $this->fetchResult($select);

        return $rowSet;
    }
}