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

use UthandoNewsletter\Model\Subscriber;
use UthandoUser\Model\User;
use UthandoUser\Model\User as UserModel;
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
            'UthandoUser\Service\User',
        ], ['pre.add'], [$this, 'getSubscriptionList']);

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

        /* @var \UthandoNewsletter\Form\Element\SubscriptionList $subscriptionList */
        $subscriptionList = $e->getTarget()
            ->getServiceLocator()
            ->get('FormElementManager')
            ->get('UthandoNewsletterSubscriptionList');

        if (isset($post['subscribe'])) {
            $subscriptionList->setValue($post['subscribe']);
        }

        $form->add($subscriptionList);

        $inputFilter = $form->getInputFilter();
        $inputFilter->add($subscriptionList->getInputSpecification());

        $validationGroup = $form->getValidationGroup();
        $validationGroup[] = 'subscribe';
        $form->setValidationGroup($validationGroup);

        $e->setParam('form', $form);
    }

    /**
     * @param Event $e
     * @return bool
     */
    public function addSubscriber(Event $e)
    {
        $data = $e->getParam('post');

        if (isset($data['subscribe'])) {
            /* @var User $model */
            $userId = $e->getParam('saved', null);
            /* @var UserModel $model */
            $model = $e->getTarget()->getById($userId);

            if ($model instanceof UserModel) {
                /* @var $subscriberService \UthandoNewsletter\Service\Subscriber */
                $subscriberService = $e->getTarget()->getService('UthandoNewsletterSubscriber');

                $subscriber = $subscriberService->getSubscriberByEmail($model->getEmail());

                if (!$subscriber instanceof Subscriber || $subscriber->getSubscriberId()) {
                    return false;
                }

                $subscriberData = [
                    'name'      => $model->getFullName(),
                    'email'     => $model->getEmail(),
                    'subscribe' => $data['subscribe'],
                ];

                $subscriberService->add($subscriberData);
            }
        }

    }

    /**
     * @param Event $e
     * @return bool
     */
    public function emailUpdate(Event $e)
    {
        $data = $e->getParam('post');

        /* @var $subscriberService \UthandoNewsletter\Service\Subscriber */
        $subscriberService = $e->getTarget()->getService('UthandoNewsletterSubscriber');

        $subscriber = $subscriberService->getSubscriberByEmail($this->userEmail);

        if (!$subscriber instanceof Subscriber || null === $subscriber->getSubscriberId()) {
            return false;
        }

        if ($this->userEmail !== $data['email']) {
            $subscriber->setEmail($data['email']);
            $subscriberService->save($subscriber);
        }
    }
}
