<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\View\Renderer
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace UthandoNewsletter\View\Renderer;

use UthandoNewsletter\Model\Message;
use UthandoNewsletter\Model\Template;

/**
 * Class NewsletterEngine
 *
 * @package UthandoNewsletter\View\Renderer
 */
class NewsletterEngine
{
    /**
     * @var array
     */
    protected $variables;

    /**
     * @return array
     */
    public function getVariables()
    {
        return $this->variables;
    }

    /**
     * @param array $variables
     * @return $this
     */
    public function setVariables($variables)
    {
        $this->variables = $variables;
        return $this;
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function setVariable($name, $value)
    {
        $this->variables[$name] = $value;
        return $this;
    }

    /**
     * @param $html
     * @return string
     */
    public function parseVariables($html)
    {
        foreach ($this->getVariables() as $key => $variable)
        {
            $html = str_replace('{' . $key . '}', $variable, $html);
        }

        return $html;
    }

    /**
     * @param Template|Message $model
     * @return string
     */
    public function render($model)
    {
        if ($model instanceof Template) {
            $html = $this->parseVariables($model->getBody());
        } else {
            $this->setVariable('content', $model->getMessage());
            $html = $this->parseVariables($model->getTemplate()->getBody());
        }

        return $html;
    }
}