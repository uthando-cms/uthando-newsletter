<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletterTest\Hydrator
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletterTest\Hydrator;

use UthandoNewsletter\Hydrator\TemplateHydrator;
use UthandoNewsletter\Model\TemplateModel as TemplateModel;
use UthandoNewsletterTest\Framework\TestCase;

class TemplateTest extends TestCase
{
    public function testCanGetFromServiceManager()
    {
        $hydrator = $this->serviceManager
            ->get('HydratorManager')
            ->get('UthandoNewsletterTemplate');
        $this->assertInstanceOf(TemplateHydrator::class, $hydrator);
    }

    public function testExtract()
    {
        $data = [
            'templateId'    => 1,
            'name'          => 'Test',
            'params'        => 'title=Test',
            'body'          => file_get_contents(__DIR__ . '/../TestAssets/body.phtml'),
        ];

        $hydrator = new TemplateHydrator();
        $model = $hydrator->hydrate($data, new TemplateModel());
        $this->assertSame($data, $hydrator->extract($model));
    }
}
