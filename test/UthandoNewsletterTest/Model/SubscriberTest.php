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

use UthandoNewsletter\Model\Subscriber;
use UthandoNewsletter\Model\Subscription;
use UthandoNewsletterTest\Framework\TestCase;

class SubscriberTest extends TestCase
{
    /**
     * @var Subscriber
     */
    protected $model;

    public function setUp()
    {
        parent::setUp();
        $model = new Subscriber();
        $this->model = $model;
    }

    public function testSetGetSubscriberId()
    {
        $this->model->setSubscriberId(1);
        $this->assertSame(1, $this->model->getSubscriberId());
    }

    public function testSetGetName()
    {
        $this->model->setName('Joe Bloggs');
        $this->assertSame('Joe Bloggs', $this->model->getName());
    }

    public function testSetGetEmail()
    {
        $this->model->setEmail('joe@bloggs.com');
        $this->assertSame('joe@bloggs.com', $this->model->getEmail());
    }

    public function testSetGetSubscriptions()
    {
        $subscription = new Subscription();
        $subscription->setNewsletterId(1)
            ->getSubscriberId(1);

        $this->model->setSubscriptions($subscription);

        $this->assertSame([$subscription], $this->model->getSubscriptions());
        $this->assertSame($subscription, $this->model->getSubscriptions(1));
    }

    public function testSetGetSubscribe()
    {
        $this->model->setSubscribe([
            1 => 2,
            2 => 3,
        ]);

        $this->assertSame([
            1 => 2,
            2 => 3,
        ], $this->model->getSubscribe());
    }
}
