<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletterTest\Mapper
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoNewsletterTest\Mapper;

use Zend\Db\Adapter\Platform\Sql92;

class TrustingSql92Platform extends Sql92
{
    /**
    * {@inheritDoc}
    */
    public function quoteValue($value)
    {
        return $this->quoteTrustedValue($value);
    }
}
