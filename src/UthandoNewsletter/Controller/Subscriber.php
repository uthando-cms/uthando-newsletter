<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace UthandoNewsletter\Controller;

use UthandoCommon\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;

/**
 * Class Subscriber
 *
 * @package UthandoNewsletter\Controller
 * @method \UthandoNewsletter\Service\Subscriber getService()
 */
class Subscriber extends AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'subscriberId'];
    protected $serviceName = 'UthandoNewsletterSubscriber';
    protected $route = 'admin/newsletter/subscriber';

    public function editAction()
    {
        $id = (int) $this->params('id', 0);
        $this->getService()->setFormOptions([
            'subscriber_id' => $id,
        ]);

        return parent::editAction();
    }

    public function addSubscriberAction()
    {
        $request = $this->getRequest();

        if (!$request->isPost() && !$request->isXmlHttpRequest()) {
            return $this->redirect()->toRoute('home');
        }

        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);

        $post = $this->params()->fromPost();

        try {
            $result = $this->getService()
                ->add($post);
        } catch (\Exception $e) {
            $result = false;
            $viewModel->setTemplate('uthando-newsletter/subscriber/error');
        }

        return $viewModel->setVariable('result', $result);
    }

}
