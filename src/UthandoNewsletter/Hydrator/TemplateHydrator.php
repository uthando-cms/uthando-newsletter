<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\Hydrator
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletter\Hydrator;

use UthandoCommon\Hydrator\AbstractHydrator;
use UthandoNewsletter\Model\TemplateModel as TemplateModel;

/**
 * Class Template
 *
 * @package UthandoNewsletter\Hydrator
 */
class TemplateHydrator extends AbstractHydrator
{
    /**
     * @param TemplateModel $object
     * @return array
     */
    public function extract($object)
    {
        return [
            'templateId'    => $object->getTemplateId(),
            'name'          => $object->getName(),
            'params'        => $object->getParams(),
            'body'          => $object->getBody(),
        ];
    }
}