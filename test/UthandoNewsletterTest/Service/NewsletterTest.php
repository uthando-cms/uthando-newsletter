<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletterTest\Service
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletterTest\Service;

use UthandoNewsletter\Model\Newsletter as NewsletterModel;
use UthandoNewsletter\Service\Newsletter;
use UthandoNewsletterTest\Framework\TestCase;

class NewsletterTest extends TestCase
{
    public function testCanGetFromServiceManager()
    {
        $service = $this->serviceManager
            ->get('UthandoServiceManager')
            ->get('UthandoNewsletter');

        $this->assertInstanceOf(Newsletter::class, $service);
    }

    public function testFetchVisibleNewsletters()
    {
        $model = new NewsletterModel();
        $model->setNewsletterId(1)
            ->setDescription('Test newsletter')
            ->setName('Test')
            ->setVisible(true);

        $newsletterMapperMock = $this->getMock('UthandoNewsletter\Mapper\Newsletter');
        $newsletterMapperMock->expects($this->once())->method('fetchAllVisible')->willReturn([$model]);

        $this->serviceManager->get('UthandoMapperManager')->setAllowOverride(true);
        $this->serviceManager->get('UthandoMapperManager')->setService('UthandoNewsletter', $newsletterMapperMock);

        /* @var Newsletter $service */
        $service = $this->serviceManager
            ->get('UthandoServiceManager')
            ->get('UthandoNewsletter');
        $service->setUseCache(false);
        
        $result = $service->fetchVisibleNewsletters();

        $this->assertSame($result[0], $model);
    }

    public function testToggleVisible()
    {
        $model = new NewsletterModel();
        $model->setNewsletterId(1)
            ->setDescription('Test newsletter')
            ->setName('Test')
            ->setVisible(true);

        $newsletterMapperMock = $this->getMock('UthandoNewsletter\Mapper\Newsletter');
        $newsletterMapperMock->expects($this->once())->method('update')->willReturn(1);
        $newsletterMapperMock->expects($this->once())->method('getPrimaryKey')->willReturn('newsletterId');
        $newsletterMapperMock->expects($this->once())->method('getById')->willReturn($model);

        $this->serviceManager->get('UthandoMapperManager')->setAllowOverride(true);
        $this->serviceManager->get('UthandoMapperManager')->setService('UthandoNewsletter', $newsletterMapperMock);

        /* @var Newsletter $service */
        $service = $this->serviceManager
            ->get('UthandoServiceManager')
            ->get('UthandoNewsletter');
        $service->setUseCache(false);

        $result = $service->toggleVisible($model);

        $this->assertSame(1, $result);
    }
}
