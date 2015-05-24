<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\Hydrator
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace UthandoNewsletter\Hydrator;

use UthandoCommon\Hydrator\AbstractHydrator;
use UthandoNewsletter\Model\Template as TemplateModel;

/**
 * Class Template
 *
 * @package UthandoNewsletter\Hydrator
 */
class Template extends AbstractHydrator
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