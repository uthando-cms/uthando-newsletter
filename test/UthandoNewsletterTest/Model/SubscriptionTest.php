<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletterTest\Model
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletterTest\Model;

use UthandoNewsletter\Model\Subscription;
use UthandoNewsletterTest\Framework\TestCase;

class SubscriptionTest extends TestCase
{
    /**
     * @var Subscription
     */
    protected $model;

    public function setUp()
    {
        parent::setUp();
        $model = new Subscription();
        $this->model = $model;
    }

    public function testSetGetSubscriptionId()
    {
        $this->model->setSubscriptionId(1);
        $this->assertSame(1, $this->model->getSubscriptionId());
    }

    public function testSetGetNewsletterId()
    {
        $this->model->setNewsletterId(1);
        $this->assertSame(1, $this->model->getNewsletterId());
    }

    public function testSetGetSubscriberId()
    {
        $this->model->setSubscriberId(1);
        $this->assertSame(1, $this->model->getSubscriberId());
    }
}
