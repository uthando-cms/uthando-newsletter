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

use UthandoNewsletter\Form\Element\TemplateList;
use UthandoNewsletter\Model\TemplateModel;
use UthandoNewsletterTest\Framework\TestCase;

class TemplateListTest extends TestCase
{
    public function testCanCreateFormServiceManager()
    {
        /* @var $form TemplateModel */
        $form = $this->serviceManager->get('FormElementManager')
            ->get('UthandoNewsLetterTemplateList');

        $this->assertInstanceOf(TemplateList::class, $form);

    }

    public function testGetTemplates()
    {
        $model = new TemplateModel();
        $model->setTemplateId(1)
            ->setName('Test');

        $mapperMock = $this->getMockBuilder('UthandoNewsletter\Mapper\TemplateMapper')
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
            ->with('UthandoNewsletterTemplate')
            ->will($this->returnValue($mapperMock));

        $this->serviceManager->setAllowOverride(true);
        $this->serviceManager->setService('UthandoServiceManager', $serviceManagerMock);

        /* @var $form TemplateModel */
        $form = $this->serviceManager->get('FormElementManager')
            ->get('UthandoNewsLetterTemplateList');

        $this->assertSame([1 => 'Test'], $form->getValueOptions());
    }
}
