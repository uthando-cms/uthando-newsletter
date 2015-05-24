<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\Service
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace UthandoNewsletter\Service;

use UthandoCommon\Service\AbstractMapperService;
use UthandoNewsletter\Model\Newsletter as NewsletterModel;

/**
 * Class Newsletter
 *
 * @package UthandoNewsletter\Service
 * @method \UthandoNewsletter\Mapper\Newsletter getMapper($mapperClass = null, array $options = [])
 */
class Newsletter extends AbstractMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'UthandoNewsletter';

    /**
     * @param NewsletterModel $model
     * @return int
     * @throws \UthandoCommon\Service\ServiceException
     */
    public function toggleEnabled(NewsletterModel $model)
    {
        $this->removeCacheItem($model->getNewsletterId());

        $enabled = (true === $model->isEnabled()) ? false : true;

        $model->setEnabled($enabled);

        return parent::save($model);
    }
}