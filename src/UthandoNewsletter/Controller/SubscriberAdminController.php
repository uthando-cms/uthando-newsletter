<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\Mvc\Controller
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletter\Controller;

use UthandoCommon\Controller\AbstractCrudController;
use UthandoNewsletter\Service\SubscriberService;

/**
 * Class SubscriberAdmin
 *
 * @package UthandoNewsletter\Mvc\Controller
 */
class SubscriberAdminController extends AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'subscriberId'];
    protected $serviceName = SubscriberService::class;
    protected $route = 'admin/newsletter/subscriber';

    public function editAction()
    {
        $id = (int) $this->params('id', 0);
        $this->getService()->setFormOptions([
            'subscriber_id' => $id,
        ]);

        return parent::editAction();
    }
}
