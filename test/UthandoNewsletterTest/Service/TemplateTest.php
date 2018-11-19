<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletterTest\Service
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletterTest\Service;

use UthandoNewsletter\Service\TemplateService;
use UthandoNewsletterTest\Framework\TestCase;

class TemplateTest extends TestCase
{
    public function testCanGetFromServiceManager()
    {
        /* @var TemplateService $service */
        $service = $this->serviceManager
            ->get('UthandoServiceManager')
            ->get('UthandoNewsletterTemplate');

        $this->assertInstanceOf(TemplateService::class, $service);
    }
}
