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

use UthandoCommon\Service\ServiceTrait;
use UthandoNewsletter\Form\Preferences as PreferencesForm;
use UthandoNewsletter\Service\Subscriber;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Class Preferences
 *
 * @package UthandoNewsletter\Mvc\Controller
 */
class Preferences extends AbstractActionController
{
    use ServiceTrait;

    public function indexAction()
    {
        $prg = $this->prg();

        /* @var Subscriber $service */
        $service = $this->getService('UthandoNewsletterSubscriber');
        $form = $service->getForm('UthandoNewsletterPreferences');

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
