<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   ${NAMESPACE}
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
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
class Newsletter implements ModelInterface
{
    use Model,
        DateCreatedTrait;

    /**
     * @var int
     */
    protected $newsletterId;

    /**
     * @var string
     */
    protected $email;

    /**
     * @return int
     */
    public function getNewsletterId()
    {
        return $this->newsletterId;
    }

    /**
     * @param int $newsletterId
     * @return $this
     */
    public function setNewsletterId($newsletterId)
    {
        $this->newsletterId = $newsletterId;
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
}