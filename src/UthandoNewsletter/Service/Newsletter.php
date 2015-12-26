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
 * @method \UthandoNewsletter\Model\Newsletter|array|null getById($id, $col = null)
 * @method \UthandoNewsletter\Mapper\Newsletter getMapper($mapperClass = null, array $options = [])
 */
class Newsletter extends AbstractMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'UthandoNewsletter';

    /**
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function fetchVisibleNewsletters()
    {
        $models = $this->getMapper()->fetchAllVisible();
        return $models;
    }

    /**
     * @param NewsletterModel $model
     * @return int
     * @throws \UthandoCommon\Service\ServiceException
     */
    public function toggleVisible(NewsletterModel $model)
    {
        $this->removeCacheItem($model->getNewsletterId());

        $visible = (true === $model->isVisible()) ? false : true;

        $model->setVisible($visible);

        return parent::save($model);
    }
}