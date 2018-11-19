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

use UthandoCommon\Service\ServiceTrait;
use UthandoNewsletter\Form\SubscriberEditForm;
use UthandoNewsletter\Service\SubscriberService as SubscriberService;
use UthandoUser\Model\UserModel;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class Subscriber
 *
 * @package UthandoNewsletter\Mvc\Controller
 * @method SubscriberService getService()
 * @method UserModel identity()
 */
class SubscriberController extends AbstractActionController
{
    use ServiceTrait;

    public function __construct()
    {
        $this->serviceName = SubscriberService::class;
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


        /** @var SubscriberEditForm $form */
        $form = $this->getService('FormElementManager')
            ->get(SubscriberEditForm::class, [
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
                'form' => $form->bind($subscriber),
            ];
        }

        $inputFilter = $this->getService()->getInputFilter();
        $hydrator = $this->getService()->getHydrator();

        $form->setInputFilter($inputFilter);
        $form->setHydrator($hydrator);
        $form->bind($subscriber);

        if (null === $subscriber->getSubscriberId()) {
            $result = $this->getService()
                ->add($prg, $form);
        } else {
            $result = $this->getService()
                ->edit($subscriber, $prg, $form);
        }

        if ($result instanceof SubscriberForm) {
            $this->flashMessenger()->addErrorMessage(
                'There were one or more issues with your submission. Please correct them as indicated below.'
            );

            $form = $result;
        } else {
            if ($result) {
                $this->flashMessenger()->addSuccessMessage(
                    'Your settings were updated.'
                );
            } else {
                $this->flashMessenger()->addInfoMessage(
                    'No changes were made.'
                );
            }
            $subscriber = $this->getService()
                ->getSubscriberByEmail($this->identity()->getEmail());

            $form->bind($subscriber);
        }

        return [
            'form' => $form,
        ];
    }
}
