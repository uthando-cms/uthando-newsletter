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
class Subscriber extends AbstractDbMapper
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
}