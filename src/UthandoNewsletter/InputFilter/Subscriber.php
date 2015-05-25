<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\InputFilter
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace UthandoNewsletter\InputFilter;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterPluginManager;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\Validator\Hostname;

/**
 * Class Newsletter
 *
 * @package UthandoNewsletter\InputFilter
 * @method InputFilterPluginManager getServiceLocator()
 */
class Subscriber extends InputFilter implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    public function init()
    {
        $this->add([
            'name' => 'subscriberId',
            'required' => 'false',
            'filters' => [
                ['name' => 'stringTrim'],
                ['name' => 'StripTags'],
            ],
        ]);

        $this->add([
            'name' => 'name',
            'required' => true,
            'filters' => [
                ['name' => 'stringTrim'],
                ['name' => 'StripTags'],
            ],
            'validators' => [
                ['name' => 'StringLength', 'options' => [
                    'encoding' => 'UTF-8',
                    'min'      => 2,
                    'max'      => 255,
                ]],
            ],
        ]);

        $this->add([
            'name' => 'email',
            'required' => true,
            'filters' => [
                ['name' => 'stringTrim'],
                ['name' => 'StripTags'],
            ],
            'validators' => [
                ['name' => 'EmailAddress', 'options' => [
                    'allow'            => Hostname::ALLOW_DNS,
                    'useMxCheck'       => true,
                    'useDeepMxCheck'   => true
                ]],
            ],
        ]);

        $this->add([
            'name' => 'subscribe',
            'required' => false,
            'filters' => [
                ['name' => 'stringTrim'],
                ['name' => 'StripTags'],
            ],
        ]);
    }

    public function addEmailNoRecordExists($exclude = null)
    {
        $exclude = (!$exclude) ?: [
            'field' => 'email',
            'value' => $exclude,
        ];

        $this->get('email')
            ->getValidatorChain()
            ->attachByName('Zend\Validator\Db\NoRecordExists', [
                'table'     => 'newsletter',
                'field'     => 'email',
                'adapter'   => $this->getServiceLocator()
                                    ->getServiceLocator()
                                    ->get('Zend\Db\Adapter\Adapter'),
                'exclude'   => $exclude,
            ]);

        return $this;
    }
}