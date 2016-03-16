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

use UthandoNewsletter\Form\Element\SubscriptionList;
use UthandoNewsletter\Model\Newsletter;
use UthandoNewsletter\Model\Subscription;
use UthandoNewsletterTest\Framework\TestCase;

class SubscriptionListTest extends TestCase
{
    protected $options = [
        'subscriber_id' => 1,
        'include_hidden' => false,
    ];

    protected $valueOptions = [
        [
            'label' => '<i></i>Test',
            'value' => 1,
            'selected' => true,
            'label_options' => [
                'disable_html_escape' => true,
            ]
        ],
    ];

    public function testCanCreateFormServiceManager()
    {
        /* @var $form SubscriptionList */
        $form = $this->serviceManager->get('FormElementManager')
            ->get('UthandoNewsLetterSubscriptionList');

        $this->assertInstanceOf(SubscriptionList::class, $form);
        $this->assertSame('subscribe', $form->getName());
    }

    public function testGetSetOptions()
    {
        $form = new SubscriptionList();
        $form->setOptions($this->options);

        $this->assertSame(1, $form->getSubscriberId());
        $this->assertFalse($form->isIncludeHidden());

    }

    public function testGetSubscribers()
    {
        $newsletterModel = new Newsletter();
        $subscriptionModel = new Subscription();

        $newsletterModel->setName('Test')
            ->setNewsletterId(1);
        $subscriptionModel->setNewsletterId(1)
            ->setSubscriberId(1);

        $newsletterReturnArray = [
            $newsletterModel,
        ];

        $subscriptionReturnArray = [
            $subscriptionModel,
        ];

        $newsletterServiceMock = $this->getMockBuilder('UthandoNewsletter\Service\Newsletter')
            ->disableOriginalConstructor()
            ->getMock();

        $subscriptionServiceMock = $this->getMockBuilder('UthandoNewsletter\Service\Subscription')
            ->disableOriginalConstructor()
            ->getMock();

        $subscriptionMapperMock = $this->getMockBuilder('UthandoNewsletter\Mapper\Subscription')
            ->disableOriginalConstructor()
            ->getMock();

        $newsletterServiceMock->expects($this->once())
            ->method('fetchVisibleNewsletters')
            ->will($this->returnValue($newsletterReturnArray));

        $subscriptionMapperMock->expects($this->once())
            ->method('getSubscriptionsBySubscriberId')
            ->will($this->returnValue($subscriptionReturnArray));

        $subscriptionServiceMock->expects($this->once())
            ->method('getMapper')
            ->will($this->returnValue($subscriptionMapperMock));

        $this->serviceManager->setAllowOverride(true);

        $serviceManagerMock = $this->getMockBuilder('UthandoCommon\Service\ServiceManager')
            ->disableOriginalConstructor()
            ->getMock();

        $serviceManagerMock->expects($this->exactly(2))
            ->method('get')
            ->with($this->logicalOr(
                $this->equalTo('UthandoNewsletter'),
                $this->equalTo('UthandoNewsletterSubscription')
            ))
            ->will($this->returnValueMap([
                ['UthandoNewsletter', [], true, $newsletterServiceMock],
                ['UthandoNewsletterSubscription', [], true, $subscriptionServiceMock]
            ]));

        $this->serviceManager->setService('UthandoServiceManager', $serviceManagerMock);

        /* @var $form SubscriptionList */
        $form = $this->serviceManager->get('FormElementManager')
            ->get('UthandoNewsLetterSubscriptionList');
        $form->setOptions($this->options);
        $form->setLabelPrepend(true);

        $this->assertSame($this->valueOptions, $form->getSubscribers());
    }

    public function testGetInputSpecification()
    {
        $form = new SubscriptionList();
        $form->init();
        $form->setOptions($this->options);
        $form->setValueOptions($this->valueOptions);
        $spec = $form->getInputSpecification();

        $this->assertFalse($spec['required']);
        $this->assertSame('subscribe', $spec['name']);
    }

    public function testSetGetSubscriberId()
    {
        $object = new SubscriptionList();
        $object->setSubscriberId(1);

        $this->assertEquals(1, $object->getSubscriberId());
    }

    public function testSetGetLabelPrepend()
    {
        $object = new SubscriptionList();
        $object->setLabelPrepend(true);

        $this->assertTrue($object->isLabelPrepend());
    }

    public function testSetGetLabelHtml()
    {
        $object = new SubscriptionList();

        $this->assertSame('<i></i>', $object->getLabelHtml());

        $object->setLabelHtml('<span></span>');

        $this->assertSame('<span></span>', $object->getLabelHtml());
    }

    public function testSetGetPreSelect()
    {
        $object = new SubscriptionList();
        $object->setPreSelect(true);

        $this->assertTrue($object->isPreSelect());
    }

    public function testSetGetIncludeHidden()
    {
        $object = new SubscriptionList();
        $object->setIncludeHidden(true);

        $this->assertTrue($object->isIncludeHidden());
    }
}
