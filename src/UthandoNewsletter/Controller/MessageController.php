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
use UthandoCommon\UthandoException;
use UthandoNewsletter\Service\MessageService;
use UthandoNewsletter\View\Model\NewsletterViewModel;

/**
 * Class Message
 *
 * @package UthandoNewsletter\Controller
 * @method MessageService getService($service = null, $options = [])
 */
class MessageController extends AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'messageId'];
    protected $serviceName = MessageService::class;
    protected $route = 'admin/newsletter/message';

    public function previewAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        $viewModel = new NewsletterViewModel(null, [
            'parse_images' => true,
        ]);
        $viewModel->setTemplate('message/' . $id);

        return $viewModel;
    }

    public function sendAction()
    {
        $id = $this->params()->fromRoute('id', 0);

        try {
            $result = $this->getService()->sendMessage($id);
            $this->flashMessenger()->addSuccessMessage(
                $result . ' Messages added to Mail Queue.'
            );
        } catch (UthandoException $e) {
            $this->setExceptionMessages($e);
        }
        
        return $this->redirect()->toRoute($this->getRoute());
    }
}