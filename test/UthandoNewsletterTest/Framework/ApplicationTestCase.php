<?php

namespace UthandoNewsletterTest\Framework;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class ApplicationTestCase extends AbstractHttpControllerTestCase
{
    protected function setUp()
    {
        $this->setApplicationConfig(
            include __DIR__ . '/../../TestConfig.php.dist'
        );
        parent::setUp();
    }
}