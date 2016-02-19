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

use UthandoCommon\Service\ServiceTrait;
use UthandoNewsletter\Form\Subscriber as SubscriberForm;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class Subscriber
 *
 * @package UthandoNewsletter\Mvc\Controller
 * @method \UthandoNewsletter\Service\Subscriber getService()
 * @method \UthandoUser\Model\User identity()
 */
class Subscriber extends AbstractActionController
{
    use ServiceTrait;

    /**
     * @var \UthandoUser\Service\User
     */
    protected $userService;

    public function __construct()
    {
        $this->serviceName = 'UthandoNewsletterSubscriber';
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

    public function updateSubscriptionAction()
    {
        $prg = $this->prg();

        $subscriber = $this->getService()
            ->getSubscriberByEmail($this->identity()->getEmail());
        $this->getService()->setFormOptions([
            'subscriber_id' => $subscriber->getSubscriberId(),
        ]);

        if ($prg instanceof Response) {
            return $prg;
        } elseif (false === $prg) {
            if (null === $subscriber->getSubscriberId()) {
                $subscriber->setName($this->identity()->getFullName())
                    ->setEmail($this->identity()->getEmail());
            }

            return [
                'form' => $this->getService()->getForm($subscriber)
            ];
        }

        if (null === $subscriber->getSubscriberId()) {
            $result = $this->getService()
                ->add($prg);
        } else {
            $result = $this->getService()
                ->edit($subscriber, $prg);
        }

        if ($result instanceof SubscriberForm) {
            $form = $result;
        } else {
            $subscriber = $this->getService()
                ->getSubscriberByEmail($this->identity()->getEmail());
            $this->getService()
                ->setFormOptions(['subscriber_id' => $subscriber->getSubscriberId()]);
            $form = $this->getService()->getForm($subscriber);
        }

        return [
            'form' => $form,
        ];
    }

    public function unsubscribeAction()
    {

    }

}
