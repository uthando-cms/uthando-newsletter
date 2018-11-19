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
use UthandoNewsletter\Model\NewsletterModel;
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
        $model = new NewsletterModel();
        $model->setNewsletterId(1)
            ->setName('Test');

        $mapperMock = $this->getMockBuilder('UthandoNewsletter\Mapper\NewsletterMapper')
            ->disableOriginalConstructor()
            ->getMock();

        $serviceManagerMock = $this->getMockBuilder('UthandoCommon\Service\ServiceManager')
            ->disableOriginalConstructor()
            ->getMock();

        $mapperMock->expects($this->once())
            ->method('fetchAll')
            ->will($this->returnValue(array($model)));

        $serviceManagerMock->expects($this->once())
            ->method('get')
            ->with('UthandoNewsletter')
            ->will($this->returnValue($mapperMock));

        $this->serviceManager->setAllowOverride(true);
        $this->serviceManager->setService('UthandoServiceManager', $serviceManagerMock);

        /* @var $form NewsletterList */
        $form = $this->serviceManager->get('FormElementManager')
            ->get('UthandoNewsLetterList');

        $this->assertSame([1 => 'Test'], $form->getValueOptions());
    }
}
