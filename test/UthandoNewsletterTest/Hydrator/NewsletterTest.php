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

use UthandoNewsletter\Hydrator\Newsletter;
use UthandoNewsletter\Model\Newsletter as NewsletterModel;
use UthandoNewsletterTest\Framework\TestCase;

class NewsletterTest extends TestCase
{
    public function testCanGetFromServiceManager()
    {
        $hydrator = $this->serviceManager
            ->get('HydratorManager')
            ->get('UthandoNewsletter');
        $this->assertInstanceOf(Newsletter::class, $hydrator);
    }

    public function testExtract()
    {
        $data = [
            'newsletterId'  => 1,
            'name'          => 'Test',
            'description'   => 'Test newsletter',
            'visible'       => 1,
        ];

        $hydrator = new Newsletter();
        $model = $hydrator->hydrate($data, new NewsletterModel());
        $this->assertSame($data, $hydrator->extract($model));
    }
}
