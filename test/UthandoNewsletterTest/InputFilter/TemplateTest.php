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

use UthandoNewsletter\InputFilter\TemplateInputFilter;
use UthandoNewsletterTest\Framework\TestCase;

class TemplateTest extends TestCase
{
    public function testCanGetFromServiceManager()
    {
        /* @var TemplateInputFilter $inputFilter */
        $inputFilter = $this->serviceManager
            ->get('InputFilterManager')
            ->get('UthandoNewsletterTemplate');
        $this->assertInstanceOf(TemplateInputFilter::class, $inputFilter);

        $this->assertTrue($inputFilter->has('templateId'));
        $this->assertTrue($inputFilter->has('name'));
        $this->assertTrue($inputFilter->has('params'));
        $this->assertTrue($inputFilter->has('body'));

        $this->assertEquals(4, $inputFilter->count());
    }
}
