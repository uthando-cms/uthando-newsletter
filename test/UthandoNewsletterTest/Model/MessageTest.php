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

use UthandoNewsletter\Model\Message;
use UthandoNewsletter\Model\Newsletter;
use UthandoNewsletter\Model\Template;
use UthandoNewsletterTest\Framework\TestCase;

class MessageTest extends TestCase
{
    /**
     * @var Message
     */
    protected $model;

    public function setUp()
    {
        parent::setUp();
        $model = new Message();
        $this->model = $model;
    }

    public function testSetGetMessageId()
    {
        $this->model->setMessageId(1);
        $this->assertSame(1, $this->model->getMessageId());
    }

    public function testSetGetNewsletterId()
    {
        $this->model->setNewsletterId(1);
        $this->assertSame(1, $this->model->getNewsletterId());
    }

    public function testSetGetTemplateId()
    {
        $this->model->setTemplateId(1);
        $this->assertSame(1, $this->model->getTemplateId());
    }

    public function testSetGetSubject()
    {
        $this->model->setSubject('test subject');
        $this->assertSame('test subject', $this->model->getSubject());
    }

    public function testSetGetMessage()
    {
        $this->model->setMessage('This is a message');
        $this->assertSame('This is a message', $this->model->getMessage());
    }

    public function testSetGetParams()
    {
        $this->model->setParams('subject=test');
        $this->assertSame('subject=test', $this->model->getParams());
    }

    public function testSetGetNewsletter()
    {
        $this->model->setNewsletter(new Newsletter());
        $this->assertInstanceOf(Newsletter::class, $this->model->getNewsletter());
    }

    public function testSetGetTemplate()
    {
        $this->model->setTemplate(new Template());
        $this->assertInstanceOf(Template::class, $this->model->getTemplate());
    }
}
