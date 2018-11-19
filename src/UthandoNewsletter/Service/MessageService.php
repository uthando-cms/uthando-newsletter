<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\Service
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletter\Service;

use UthandoCommon\Service\AbstractRelationalMapperService;
use UthandoCommon\UthandoException;
use UthandoNewsletter\Form\MessageForm;
use UthandoNewsletter\Hydrator\MessageHydrator;
use UthandoNewsletter\InputFilter\MessageInputFilter;
use UthandoNewsletter\Mapper\MessageMapper;
use UthandoNewsletter\Mapper\SubscriberMapper;
use UthandoNewsletter\Mapper\SubscriptionMapper;
use UthandoNewsletter\Model\MessageModel;
use UthandoNewsletter\Model\SubscriberModel;
use UthandoNewsletter\Model\SubscriptionModel;
use UthandoNewsletter\View\Model\NewsletterViewModel;
use UthandoNewsletter\View\Renderer\NewsletterRenderer;
use Zend\Config\Reader\Ini as IniReader;
use Zend\Config\Writer\Ini as IniWriter;
use Zend\View\Helper\BasePath;
use Zend\View\Helper\ServerUrl;

/**
 * Class Message
 *
 * @package UthandoNewsletter\Service
 */
class MessageService extends AbstractRelationalMapperService
{
    protected $form         = MessageForm::class;
    protected $hydrator     = MessageHydrator::class;
    protected $inputFilter  = MessageInputFilter::class;
    protected $mapper       = MessageMapper::class;
    protected $model        = MessageModel::class;

    /**
     * @var array
     */
    protected $referenceMap = [
        'newsletter'      => [
            'refCol'    => 'newsletterId',
            'service'   => NewsletterService::class,
        ],
        'template'      => [
            'refCol'    => 'templateId',
            'service'   => TemplateService::class,
        ],
    ];

    /**
     * @param $id
     * @param null $cols
     * @return \UthandoNewsletter\Model\MessageModel
     */
    public function getById($id, $cols = null)
    {
        $model = parent::getById($id, $cols);

        $this->populate($model, true);

        return $model;
    }

    /**
     * @param int $id
     * @return int
     * @throws UthandoException
     */
    public function sendMessage($id)
    {
        $message = $this->getById($id);

        if ($message->isSent()) {
            throw new UthandoException('Cannot send message out again.');
        }

        // we need to set the server url before add to mail queue
        /** @var ServerUrl $serverUrlHelper */
        $serverUrlHelper    = $this->getService('ViewHelperManager')->get('ServerUrl');
        /** @var BasePath $basePathUrlHelper */
        $basePathUrlHelper  = $this->getService('ViewHelperManager')->get('BasePath');
        $serverUrl          = $serverUrlHelper() . $basePathUrlHelper();

        $iniReader              = new IniReader();
        $iniWriter              = new IniWriter();
        $params                 = $iniReader->fromString($message->getParams());
        $params['server_url']   = $serverUrl;

        $message->setParams($iniWriter->toString($params));

        $viewModel = new NewsletterViewModel();
        $viewModel->setTemplate('message/' . $message->getMessageId());

        /* @var $subscriptionMapper SubscriptionMapper */
        $subscriptionMapper = $this->getService(SubscriptionService::class)->getMapper();
        $subscriptions      = $subscriptionMapper->getSubscriptionsByNewsletterId($message->getNewsletterId());

        $subscriberIds = [];

        /* @var $subscription SubscriptionModel */
        foreach ($subscriptions as $subscription) {
            $subscriberIds[] = $subscription->getSubscriberId();
        }

        /* @var $subscriberMapper SubscriberMapper */
        $subscriberMapper = $this->getService(SubscriberService::class)->getMapper();
        $subscribers = $subscriberMapper->getSubscribersById($subscriberIds);

        $count = 0;

        /* @var $subscriber SubscriberModel */
        foreach ($subscribers as $subscriber) {
            $this->getEventManager()->trigger('mail.queue', $this, [
                'recipient' => [
                    'name' => $subscriber->getName(),
                    'address' => $subscriber->getEmail(),
                ],
                'layout' => $viewModel,
                'body' => null,
                'subject' => $message->getSubject(),
                'renderer' => NewsletterRenderer::class,
                'transport' => 'default',
            ]);
            $count++;
        }

        // set message as sent and save to database.
        $message->setDateSent(null)
            ->setSent(true);
        $this->save($message);

        return $count;
    }
}