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

use UthandoCommon\Service\AbstractMapperService;
use UthandoNewsletter\Form\NewsletterForm;
use UthandoNewsletter\Hydrator\NewsletterHydrator;
use UthandoNewsletter\InputFilter\NewsletterInputFilter;
use UthandoNewsletter\Mapper\NewsletterMapper;
use UthandoNewsletter\Model\NewsletterModel;

/**
 * Class Newsletter
 *
 * @package UthandoNewsletter\Service
 * @method NewsletterModel|array|null getById($id, $col = null)
 * @method NewsletterMapper getMapper($mapperClass = null, array $options = [])
 */
class NewsletterService extends AbstractMapperService
{
    protected $form         = NewsletterForm::class;
    protected $hydrator     = NewsletterHydrator::class;
    protected $inputFilter  = NewsletterInputFilter::class;
    protected $mapper       = NewsletterMapper::class;
    protected $model        = NewsletterModel::class;

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