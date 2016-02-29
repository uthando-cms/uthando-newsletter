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
use UthandoNewsletter\Model\Subscriber;
use UthandoUser\Form\Register;
use UthandoUser\Model\User;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;

class UserListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    /**
     * @var User
     */
    protected $userEmail;

    /**
     * @param EventManagerInterface $events
     */
    public function attach(EventManagerInterface $events)
    {
        $events = $events->getSharedManager();

        $this->listeners[] = $events->attach([
            'UthandoUser\Service\User',
        ], ['pre.add', 'post.form.init'], [$this, 'getSubscriptionList']);

        $this->listeners[] = $events->attach([
            'UthandoUser\Service\User',
        ], ['post.add'], [$this, 'addSubscriber']);

        $this->listeners[] = $events->attach([
            'UthandoUser\Service\User',
        ], ['post.edit'], [$this, 'emailUpdate']);

        $this->listeners[] = $events->attach([
            'UthandoUser\Service\User',
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
        /* @var $form \UthandoUser\Form\Register */
        $form = $e->getParam('form');
        $post = $e->getParam('post');

        if (!$form instanceof Register) {
            return;
        }

        /* @var \UthandoNewsletter\Form\Element\SubscriptionList $subscriptionList */
        $subscriptionList = $e->getTarget()
            ->getServiceLocator()
            ->get('FormElementManager')
            ->get('UthandoNewsletterSubscriptionList');

        $subscriptionList->setOptions([
            'label' => 'Subscriptions',
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
            /* @var User $model */
            $model = $e->getTarget()->getById($userId);

            if ($model instanceof User) {
                /* @var $subscriberService \UthandoNewsletter\Service\Subscriber */
                $subscriberService = $e->getTarget()->getService('UthandoNewsletterSubscriber');

                $subscriber = $subscriberService->getSubscriberByEmail($model->getEmail());

                if (!$subscriber instanceof Subscriber || $subscriber->getSubscriberId()) {
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

        /* @var $subscriberService \UthandoNewsletter\Service\Subscriber */
        $subscriberService = $e->getTarget()->getService('UthandoNewsletterSubscriber');

        $subscriber = $subscriberService->getSubscriberByEmail($this->userEmail);

        if (!$subscriber instanceof Subscriber || null === $subscriber->getSubscriberId()) {
            return;
        }

        if ($this->userEmail !== $data['email']) {
            $subscriber->setEmail($data['email']);
            $subscriberService->save($subscriber);
        }
    }
}
