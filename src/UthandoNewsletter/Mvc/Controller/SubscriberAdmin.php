<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\Mvc\Controller
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletter\Mvc\Controller;

use UthandoCommon\Controller\AbstractCrudController;

/**
 * Class SubscriberAdmin
 *
 * @package UthandoNewsletter\Mvc\Controller
 */
class SubscriberAdmin extends AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'subscriberId'];
    protected $serviceName = 'UthandoNewsletterSubscriber';
    protected $route = 'admin/newsletter/subscriber';

    public function editAction()
    {
        \FB::info(__METHOD__);
        $id = (int) $this->params('id', 0);
        $this->getService()->setFormOptions([
            'subscriber_id' => $id,
        ]);

        return parent::editAction();
    }
}
