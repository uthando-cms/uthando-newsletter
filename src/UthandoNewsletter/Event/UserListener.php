<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\Event
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2015 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletter\Event;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use UthandoNewsletter\Form\Element\SubscriptionList;
use UthandoNewsletter\Model\SubscriberModel;
use UthandoNewsletter\Service\SubscriberService;
use UthandoUser\Form\RegisterForm;
use UthandoUser\Model\UserModel;
use UthandoUser\Service\UserService;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;

class UserListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    /**
     * @var UserModel
     */
    protected $userEmail;

    /**
     * @param EventManagerInterface $events
     */
    public function attach(EventManagerInterface $events)
    {
        $events = $events->getSharedManager();

        $this->listeners[] = $events->attach([
            UserService::class,
        ], ['pre.add', 'post.form.init'], [$this, 'getSubscriptionList']);

        $this->listeners[] = $events->attach([
            UserService::class,
        ], ['post.add'], [$this, 'addSubscriber']);

        $this->listeners[] = $events->attach([
            UserService::class,
        ], ['post.edit'], [$this, 'emailUpdate']);

        $this->listeners[] = $events->attach([
            UserService::class,
        ], ['pre.edit'], [$this, 'setUserModel']);
    }

    public function setUserModel(Event $e)
    {
        $this->userEmail = $e->getParam('model')->getEmail();
    }

    /**
     * @param Event $e
     */
    public function getSubscriptionList(Event $e)
    {
        /* @var $form \UthandoUser\Form\RegisterForm */
        $form = $e->getParam('form');
        $post = $e->getParam('post');

        if (!$form instanceof RegisterForm) {
            return;
        }

        /* @var \UthandoNewsletter\Form\Element\SubscriptionList $subscriptionList */
        $subscriptionList = $e->getTarget()
            ->getServiceLocator()
            ->get('FormElementManager')
            ->get(SubscriptionList::class);

        if (0 === count($subscriptionList->getValueOptions())) {
            return;
        }

        $subscriptionList->setOptions([
            'label' => 'Newsletter',
            'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
            'column-size' => 'sm-10',
            'label_attributes' => [
                'class' => 'col-sm-2',
            ],
        ]);

        if (isset($post['subscribe'])) {
            $subscriptionList->setValue($post['subscribe']);
        }

        $form->add($subscriptionList);

        $validationGroup = $form->getValidationGroup();
        $validationGroup[] = 'subscribe';
        $form->setValidationGroup($validationGroup);

        $e->setParam('form', $form);
    }

    /**
     * @param Event $e
     */
    public function addSubscriber(Event $e)
    {
        $data = $e->getParam('post');

        if (isset($data['subscribe'])) {
            $userId = $e->getParam('saved', null);
            /* @var UserModel $model */
            $model = $e->getTarget()->getById($userId);

            if ($model instanceof UserModel) {
                /* @var $subscriberService SubscriberService */
                $subscriberService = $e->getTarget()->getService(SubscriberService::class);

                $subscriber = $subscriberService->getSubscriberByEmail($model->getEmail());

                if (!$subscriber instanceof SubscriberModel || $subscriber->getSubscriberId()) {
                    return;
                }

                $subscriberData = [
                    'name'      => $model->getFullName(),
                    'email'     => $model->getEmail(),
                    'subscribe' => $data['subscribe'],
                ];

                $form = $subscriberService->prepareForm($subscriber, $subscriberData, true, true);
                $form->setValidationGroup(['name', 'email', 'subscribe']);

                $subscriberService->add($subscriberData, $form);
            }
        }
    }

    /**
     * @param Event $e
     */
    public function emailUpdate(Event $e)
    {
        $data = $e->getParam('post');

        /* @var $subscriberService SubscriberService */
        $subscriberService = $e->getTarget()->getService(SubscriberService::class);

        $subscriber = $subscriberService->getSubscriberByEmail($this->userEmail);

        if (!$subscriber instanceof SubscriberModel || null === $subscriber->getSubscriberId()) {
            return;
        }

        if ($this->userEmail !== $data['email']) {
            $subscriber->setEmail($data['email']);
            $subscriberService->save($subscriber);
        }
    }
}
