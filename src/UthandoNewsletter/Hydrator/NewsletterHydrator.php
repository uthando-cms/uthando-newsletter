<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\Hydrator
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletter\Hydrator;

use UthandoCommon\Hydrator\AbstractHydrator;
use UthandoCommon\Hydrator\Strategy\TrueFalse;

/**
 * Class Newsletter
 *
 * @package UthandoNewsletter\Hydrator
 */
class NewsletterHydrator extends AbstractHydrator
{
    /**
     * Newsletter constructor. Set up strategies
     */
    public function __construct()
    {
        parent::__construct();

        $this->addStrategy('visible', new TrueFalse());
    }

    /**
     * @param \UthandoNewsletter\Model\NewsletterModel $object
     * @return array
     */
    public function extract($object)
    {
        return [
            'newsletterId'  => $object->getNewsletterId(),
            'name'          => $object->getName(),
            'description'   => $object->getDescription(),
            'visible'       => $this->extractValue('visible', $object->isVisible()),
        ];
    }
}