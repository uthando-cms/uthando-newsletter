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


use UthandoNewsletter\Hydrator\Message;
use UthandoNewsletter\Model\Message as MessageModel;
use UthandoNewsletterTest\Framework\TestCase;

class MessageTest extends TestCase
{
    public function testCanGetHydratorFromServiceManager()
    {
        $hydrator = $this->serviceManager
            ->get('HydratorManager')
            ->get('UthandoNewsletterMessage');
        $this->assertInstanceOf(Message::class, $hydrator);
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
        ];

        $hydrator = new Message();
        $model = $hydrator->hydrate($data, new MessageModel());
        $this->assertSame($data, $hydrator->extract($model));

    }
}
