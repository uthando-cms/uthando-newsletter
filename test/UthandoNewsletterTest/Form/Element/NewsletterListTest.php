<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletterTest\Form\Element
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletterTest\Form\Element;

use UthandoNewsletter\Form\Element\NewsletterList;
use UthandoNewsletterTest\Framework\TestCase;

class NewsletterListTest extends TestCase
{
    public function testCanCreateFormServiceManager()
    {
        /* @var $form NewsletterList */
        $form = $this->serviceManager
            ->get('FormElementManager')
            ->get('UthandoNewsLetterList');

        $this->assertInstanceOf(NewsletterList::class, $form);
    }

    public function testGetNewsletters()
    {
        $mapperMock = $this->getMockBuilder('UthandoNewsletter\Mapper\Newsletter')
            ->disableOriginalConstructor()
            ->getMock();

        $serviceManagerMock = $this->getMockBuilder('UthandoCommon\Service\ServiceManager')
            ->disableOriginalConstructor()
            ->getMock();

        $mapperMock->expects($this->once())
            ->method('fetchAll')
            ->will($this->returnValue(array()));

        $serviceManagerMock->expects($this->once())
            ->method('get')
            ->with('UthandoNewsletter')
            ->will($this->returnValue($mapperMock));

        $this->serviceManager->setAllowOverride(true);
        $this->serviceManager->setService('UthandoServiceManager', $serviceManagerMock);

        /* @var $form NewsletterList */
        $form = $this->serviceManager->get('FormElementManager')
            ->get('UthandoNewsLetterList');

        $this->assertSame([], $form->getValueOptions());
    }
}
