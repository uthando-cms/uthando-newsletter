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

use UthandoNewsletter\InputFilter\Subscriber;
use UthandoNewsletterTest\Framework\TestCase;

class SubscriberTest extends TestCase
{
    public function testCanGetFromServiceManager()
    {
        /* @var Subscriber $inputFilter */
        $inputFilter = $this->serviceManager
            ->get('InputFilterManager')
            ->get('UthandoNewsletterSubscriber');
        $this->assertInstanceOf(Subscriber::class, $inputFilter);

        $this->assertTrue($inputFilter->has('subscriberId'));
        $this->assertTrue($inputFilter->has('name'));
        $this->assertTrue($inputFilter->has('email'));
        $this->assertTrue($inputFilter->has('subscribe'));
        $this->assertTrue($inputFilter->has('dateCreated'));

        $this->assertEquals(5, $inputFilter->count());
    }

    public function testAddEmailNoRecordExists()
    {
        $dbAdapterMock = $this->getMockBuilder('Zend\Db\Adapter\Adapter')
            ->disableOriginalConstructor()
            ->getMock();
        $this->serviceManager->setAllowOverride(true);
        $this->serviceManager->setService('Zend\Db\Adapter\Adapter', $dbAdapterMock);

        /* @var Subscriber $inputFilter */
        $inputFilter = $this->serviceManager
            ->get('InputFilterManager')
            ->get('UthandoNewsletterSubscriber');

        $inputFilter->addEmailNoRecordExists('joe@bloggs.com');

        $filters = $inputFilter->get('email')
            ->getValidatorChain()
            ->getValidators();

        $this->assertEquals(2, count($filters));
        $this->assertInstanceOf('Zend\Validator\Db\NoRecordExists', $filters[1]['instance']);

    }
}
