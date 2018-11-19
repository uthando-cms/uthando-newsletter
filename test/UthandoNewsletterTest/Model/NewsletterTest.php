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

use UthandoNewsletter\Model\NewsletterModel;
use UthandoNewsletterTest\Framework\TestCase;

class NewsletterTest extends TestCase
{
    /**
     * @var NewsletterModel
     */
    protected $model;

    public function setUp()
    {
        parent::setUp();
        $model = new NewsletterModel();
        $this->model = $model;
    }

    public function testSetGetNewsletterid()
    {
        $this->model->setNewsletterId(1);
        $this->assertSame(1, $this->model->getNewsletterId());
    }

    public function testSetGetName()
    {
        $this->model->setName('Test Name');
        $this->assertSame('Test Name', $this->model->getName());
    }

    public function testSetGetDescription()
    {
        $this->model->setDescription('a same line about this newsletter');
        $this->assertSame('a same line about this newsletter', $this->model->getDescription());
    }

    public function testSetGetVisible()
    {
        $this->model->setVisible(true);
        $this->assertTrue($this->model->isVisible());
    }
}
