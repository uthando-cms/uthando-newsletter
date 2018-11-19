<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\Service
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletter\Service;

use UthandoCommon\Service\AbstractMapperService;
use UthandoNewsletter\Form\TemplateForm;
use UthandoNewsletter\Hydrator\TemplateHydrator;
use UthandoNewsletter\InputFilter\TemplateInputFilter;
use UthandoNewsletter\Mapper\TemplateMapper;
use UthandoNewsletter\Model\TemplateModel;

/**
 * Class Template
 *
 * @package UthandoNewsletter\Service
 * @method TemplateModel|array|null getById($id, $col = null)
 */
class TemplateService extends AbstractMapperService
{
    protected $form         = TemplateForm::class;
    protected $hydrator     = TemplateHydrator::class;
    protected $inputFilter  = TemplateInputFilter::class;
    protected $mapper       = TemplateMapper::class;
    protected $model        = TemplateModel::class;
}