<?php

namespace UthandoNewsletterTest\Framework;

use UthandoNewsletterTest\Bootstrap;
use UthandoNewsletterTest\Mapper\TrustingMysqlPlatform;
use UthandoUser\Model\User as TestUserModel;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class ApplicationTestCase extends AbstractHttpControllerTestCase
{
    protected $traceError = true;

    protected function setUp()
    {
        ini_set('error_reporting', E_ALL ^ E_USER_DEPRECATED);
        Bootstrap::init();

        $this->setApplicationConfig(
            include __DIR__ . '/../../TestConfig.php.dist'
        );
        parent::setUp();

        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);

        // mock the adapter, driver, and parts
        $mockResult = $this->getMock('Zend\Db\Adapter\Driver\ResultInterface');
        $mockStatement = $this->getMock('Zend\Db\Adapter\Driver\StatementInterface');
        $mockStatement->expects($this->any())->method('execute')->will($this->returnValue($mockResult));
        $mockConnection = $this->getMock('Zend\Db\Adapter\Driver\ConnectionInterface');
        $mockDriver = $this->getMock('Zend\Db\Adapter\Driver\DriverInterface');
        $mockDriver->expects($this->any())->method('createStatement')->will($this->returnValue($mockStatement));
        $mockDriver->expects($this->any())->method('getConnection')->will($this->returnValue($mockConnection));
        $mockDriver->expects($this->any())->method('formatParameterName')->will($this->returnValue('?'));
        // setup mock adapter
        $this->mockAdapter = $this->getMock('Zend\Db\Adapter\Adapter', null, [$mockDriver, new TrustingMysqlPlatform()]);

        $serviceManager->setService('Zend\Db\Adapter\Adapter', $this->mockAdapter);
    }

    protected function setAjaxRequest()
    {
        $request = $this->getRequest();
        $headers = $request->getHeaders();
        $headers->addHeaders(array('X-Requested-With' =>'XMLHttpRequest'));
    }

    protected function getGuestUser()
    {
        /* @var $auth \UthandoUser\Service\Authentication */
        $auth = $this->getApplicationServiceLocator()
            ->get('Zend\Authentication\AuthenticationService');
        $auth->clear();
    }

    protected function getAdminUser()
    {
        /* @var $auth \UthandoUser\Service\Authentication */
        $auth = $this->getApplicationServiceLocator()
            ->get('Zend\Authentication\AuthenticationService');
        $user = new TestUserModel();

        $user->setFirstname('Joe')
            ->setLastname('Bloggs')
            ->setEmail('email@example.com')
            ->setRole('admin')
            ->setDateCreated(new \DateTime())
            ->setDateModified(new \DateTime());
        $auth->getStorage()->write($user);
        return $user;
    }

    protected function getRegisteredUser()
    {
        /* @var $auth \UthandoUser\Service\Authentication */
        $auth = $this->getApplicationServiceLocator()
            ->get('Zend\Authentication\AuthenticationService');
        $user = new TestUserModel();

        $user->setFirstname('Joe')
            ->setLastname('Bloggs')
            ->setEmail('email@example.com')
            ->setRole('registered')
            ->setDateCreated(new \DateTime())
            ->setDateModified(new \DateTime());
        $auth->getStorage()->write($user);
        return $user;
    }
}