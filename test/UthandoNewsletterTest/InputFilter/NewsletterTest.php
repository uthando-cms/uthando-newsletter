<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletterTest\InputFilter
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletterTest\InputFilter;

use UthandoNewsletter\InputFilter\NewsletterInputFilter;
use UthandoNewsletterTest\Framework\TestCase;

class NewsletterTest extends TestCase
{
    public function testCanGetFromServiceManager()
    {
        /* @var NewsletterInputFilter $inputFilter */
        $inputFilter = $this->serviceManager
            ->get('InputFilterManager')
            ->get('UthandoNewsletter');
        $this->assertInstanceOf(NewsletterInputFilter::class, $inputFilter);

        $this->assertTrue($inputFilter->has('newsletterId'));
        $this->assertTrue($inputFilter->has('name'));
        $this->assertTrue($inputFilter->has('description'));

        $this->assertEquals(3, $inputFilter->count());
    }
}
