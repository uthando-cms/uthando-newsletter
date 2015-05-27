<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\Controller
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace UthandoNewsletter\Controller;

use UthandoCommon\Controller\AbstractCrudController;
use UthandoNewsletter\View\Model\NewsletterModel;

/**
 * Class Message
 *
 * @package UthandoNewsletter\Controller
 */
class Message extends  AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'messageId'];
    protected $serviceName = 'UthandoNewsletterMessage';
    protected $route = 'admin/newsletter/message';

    public function previewAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        $viewModel = new NewsletterModel();
        $viewModel->setTemplate('message/' . $id);

        return $viewModel;
    }
}