<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\Mvc\Controller
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletter\Mvc\Controller;

use UthandoCommon\Controller\AbstractCrudController;
use UthandoNewsletter\View\Model\NewsletterModel;

/**
 * Class Template
 *
 * @package UthandoNewsletter\Mvc\Controller
 */
class Template extends AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'templateId'];
    protected $serviceName = 'UthandoNewsletterTemplate';
    protected $route = 'admin/newsletter/template';

    public function previewAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        $viewModel = new NewsletterModel(null, [
            'parse_images' => true,
        ]);
        $viewModel->setTemplate('template/' . $id);

        return $viewModel;
    }
}