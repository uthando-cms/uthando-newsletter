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

use UthandoCommon\Hydrator\Strategy\TrueFalse;
use UthandoNewsletter\Hydrator\NewsletterHydrator;
use UthandoNewsletter\Model\NewsletterModel as NewsletterModel;
use UthandoNewsletterTest\Framework\TestCase;

class NewsletterTest extends TestCase
{
    public function testCanGetFromServiceManager()
    {
        $hydrator = $this->serviceManager
            ->get('HydratorManager')
            ->get('UthandoNewsletter');
        $this->assertInstanceOf(NewsletterHydrator::class, $hydrator);
    }

    public function testHydratorHasCorrectStrategiesSet()
    {
        $hydrator = new NewsletterHydrator();

        $this->assertTrue($hydrator->hasStrategy('visible'));
        $this->assertInstanceOf(TrueFalse::class , $hydrator->getStrategy('visible'));
    }

    public function testExtract()
    {
        $data = [
            'newsletterId'  => 1,
            'name'          => 'Test',
            'description'   => 'Test newsletter',
            'visible'       => 1,
        ];

        $hydrator = new NewsletterHydrator();
        $model = $hydrator->hydrate($data, new NewsletterModel());
        $this->assertSame($data, $hydrator->extract($model));
    }
}
