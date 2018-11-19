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

use UthandoCommon\Service\ServiceTrait;
use UthandoNewsletter\Form\PreferencesForm;
use UthandoNewsletter\Service\SubscriberService;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Class Preferences
 *
 * @package UthandoNewsletter\Controller
 */
class PreferencesController extends AbstractActionController
{
    use ServiceTrait;

    public function indexAction()
    {
        $prg = $this->prg();

        /* @var SubscriberService $service */
        $service = $this->getService(SubscriberService::class);
        $form = $service->getForm(PreferencesForm::class);

        if ($prg instanceof Response) {
            return $prg;
        } elseif (false === $prg) {
            return [
                'form' => $form,
            ];
        }

        $result = $service->removeSubscriberFromList($prg, $form);

        if ($result instanceof PreferencesForm) {
            $this->flashMessenger()->addErrorMessage(
                'There were one or more issues with your submission. Please correct them as indicated below.'
            );
            return [
                'form' => $form,
            ];
        }

        return [
            'result' => $result,
        ];
    }
}
