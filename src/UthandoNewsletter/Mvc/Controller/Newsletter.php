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

use UthandoCommon\Controller\AbstractCrudController;
use UthandoNewsletter\Model\Newsletter as NewsletterModel;

/**
 * Class Newsletter
 *
 * @package UthandoNewsletter\Mvc\Controller
 * @method \UthandoNewsletter\Service\Newsletter getService()
 */
class Newsletter extends AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'newsletterId'];
    protected $serviceName = 'UthandoNewsletter';
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