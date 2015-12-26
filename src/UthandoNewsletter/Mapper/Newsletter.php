<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\Mapper
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace UthandoNewsletter\Mapper;

use UthandoCommon\Mapper\AbstractDbMapper;

/**
 * Class Newsletter
 *
 * @package UthandoNewsletter\Mapper
 */
class Newsletter extends AbstractDbMapper
{
    protected $table = 'newsletter';
    protected $primary = 'newsletterId';

    /**
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function fetchAllVisible()
    {
        $select = $this->getSelect();
        $select->where->equalTo('visible', 1);

        $rowSet = $this->fetchResult($select);
        return $rowSet;
    }

}