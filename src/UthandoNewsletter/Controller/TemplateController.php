<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\Mvc\Controller
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletter\Controller;

use UthandoCommon\Controller\AbstractCrudController;
use UthandoNewsletter\Service\TemplateService;
use UthandoNewsletter\View\Model\NewsletterViewModel;

/**
 * Class Template
 *
 * @package UthandoNewsletter\Controller
 */
class TemplateController extends AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'templateId'];
    protected $serviceName = TemplateService::class;
    protected $route = 'admin/newsletter/template';

    public function previewAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        $viewModel = new NewsletterViewModel(null, [
            'parse_images' => true,
        ]);
        $viewModel->setTemplate('template/' . $id);

        return $viewModel;
    }
}