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


use UthandoNewsletter\Model\Template;
use UthandoNewsletterTest\Framework\TestCase;

class TemplateTest extends TestCase
{
    /**
     * @var Template
     */
    protected $model;

    public function setUp()
    {
        parent::setUp();
        $model = new Template();
        $this->model = $model;
    }

    public function testSetGetTemplateId()
    {
        $this->model->setTemplateId(1);
        $this->assertSame(1, $this->model->getTemplateId());
    }

    public function testSetGetName()
    {
        $this->model->setName('Test Name');
        $this->assertSame('Test Name', $this->model->getName());
    }

    public function testSetGetBody()
    {
        $body = file_get_contents(__DIR__ . '/../assets/body.phtml');
        $this->model->setBody($body);
        $this->assertStringEqualsFile(__DIR__ . '/../assets/body.phtml', $this->model->getBody());
    }

    public function testSetGetParams()
    {
        $this->model->setParams('test_param=test');
        $this->assertSame('test_param=test', $this->model->getParams());
    }
}
