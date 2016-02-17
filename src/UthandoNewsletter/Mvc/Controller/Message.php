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
 * Class Message
 *
 * @package UthandoNewsletter\Mvc\Controller
 * @method \UthandoNewsletter\Service\Message getService($service = null, $options = [])
 */
class Message extends  AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'messageId'];
    protected $serviceName = 'UthandoNewsletterMessage';
    protected $route = 'admin/newsletter/message';

    public function previewAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        $viewModel = new NewsletterModel(null, [
            'parse_images' => true,
        ]);
        $viewModel->setTemplate('message/' . $id);

        return $viewModel;
    }

    public function sendAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        $this->getService()->sendMessage($id);
    }
}