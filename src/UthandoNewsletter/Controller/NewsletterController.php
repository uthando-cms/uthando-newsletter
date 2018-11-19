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
use UthandoNewsletter\Model\NewsletterModel as NewsletterModel;
use UthandoNewsletter\Service\NewsletterService;

/**
 * Class Newsletter
 *
 * @package UthandoNewsletter\Mvc\Controller
 * @method NewsletterService getService()
 */
class NewsletterController extends AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'newsletterId'];
    protected $serviceName = NewsletterService::class;
    protected $route = 'admin/newsletter';

    /**
     * @return \Zend\Http\Response
     */
    public function setVisibleAction()
    {
        $id = (int) $this->params('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute($this->getRoute(), [
                'action' => 'list'
            ]);
        }

        try {
            /* @var $model NewsletterModel */
            $model = $this->getService()->getById($id);
            $this->getService()->toggleVisible($model);
        } catch (\Exception $e) {
            $this->setExceptionMessages($e);
            return $this->redirect()->toRoute($this->getRoute(), [
                'action' => 'list'
            ]);
        }

        return $this->redirect()->toRoute($this->getRoute(), [
            'action' => 'list'
        ]);
    }
}