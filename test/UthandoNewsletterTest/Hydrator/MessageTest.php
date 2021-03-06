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

use UthandoCommon\Hydrator\Strategy\DateTime;
use UthandoCommon\Hydrator\Strategy\TrueFalse;
use UthandoNewsletter\Hydrator\MessageHydrator;
use UthandoNewsletter\Model\MessageModel as MessageModel;
use UthandoNewsletterTest\Framework\TestCase;

class MessageTest extends TestCase
{
    public function testCanGetHydratorFromServiceManager()
    {
        $hydrator = $this->serviceManager
            ->get('HydratorManager')
            ->get('UthandoNewsletterMessage');
        $this->assertInstanceOf(MessageHydrator::class, $hydrator);
    }

    public function testHydratorHasCorrectStrategiesSet()
    {
        $hydrator = new MessageHydrator();

        $this->assertTrue($hydrator->hasStrategy('sent'));
        $this->assertTrue($hydrator->hasStrategy('dateCreated'));
        $this->assertTrue($hydrator->hasStrategy('dateSent'));

        $this->assertInstanceOf(TrueFalse::class , $hydrator->getStrategy('sent'));
        $this->assertInstanceOf(DateTime::class, $hydrator->getStrategy('dateCreated'));
        $this->assertInstanceOf(DateTime::class, $hydrator->getStrategy('dateSent'));
    }

    public function testExtract()
    {
        $data = [
            'messageId'     => 1,
            'newsletterId'  => 1,
            'templateId'    => 1,
            'subject'       => 'Test',
            'params'        => 'test=test',
            'message'       => '<h1>Message</h1>',
            'sent'          => 1,
            'dateCreated'   => '2016-02-19 18:12:21',
            'dateSent'      => '2016-02-19 18:12:21',
        ];

        $object = new MessageModel();
        $object->setMessageId($data['messageId'])
            ->setNewsletterId($data['newsletterId'])
            ->setTemplateId($data['templateId'])
            ->setSubject($data['subject'])
            ->setParams($data['params'])
            ->setMessage($data['message'])
            ->setSent(true)
            ->setDateCreated(new \DateTime($data['dateCreated']))
            ->setDateSent(new \DateTime($data['dateSent']));

        $hydrator = new MessageHydrator();
        $model = $hydrator->hydrate($data, new MessageModel());

        $this->assertEquals($object, $model);
        $this->assertSame($data, $hydrator->extract($model));

    }
}
