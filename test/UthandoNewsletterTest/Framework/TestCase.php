<?php

namespace UthandoNewsletterTest\Framework;

use UthandoNewsletterTest\Bootstrap;

class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $serviceManager;

    protected function setUp()
    {
        Bootstrap::init();
        $this->serviceManager = Bootstrap::getServiceManager();
    }
}