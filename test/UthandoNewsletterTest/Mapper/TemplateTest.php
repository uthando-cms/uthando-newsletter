<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletterTest\Mapper
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletterTest\Mapper;

use UthandoNewsletter\Mapper\Template;

class TemplateTest extends MapperTestCase
{
    public function testCanCreateFromServiceManager()
    {
        /* @var Template $mapper */
        $mapper = $this->serviceManager
            ->get('UthandoMapperManager')
            ->get('UthandoNewsletterTemplate');

        $this->assertInstanceOf(Template::class, $mapper);
        $this->assertSame('templateId', $mapper->getPrimaryKey());
        $this->assertSame('newsletterTemplate', $mapper->getTable());
    }
}
