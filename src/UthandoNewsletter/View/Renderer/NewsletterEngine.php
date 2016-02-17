<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoNewsletter\View\Renderer
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
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
     * @var bool
     */
    protected $parseImages = false;

    /**
     * @return boolean
     */
    public function isParseImages()
    {
        return $this->parseImages;
    }

    /**
     * @param boolean $parseImages
     * @return $this
     */
    public function setParseImages($parseImages)
    {
        $this->parseImages = $parseImages;
        return $this;
    }

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
        foreach ($this->getVariables() as $key => $variable) {
            $html = str_replace('{' . strtoupper($key) . '}', $variable, $html);
        }

        return $html;
    }

    /**
     * Renders images into inline image using base64 encoding
     *
     */
    public function renderImages()
    {
        foreach ($this->getVariables() as $key => $variable) {
            if (is_file($variable)) {
                $type = pathinfo($variable, PATHINFO_EXTENSION);
                $data = file_get_contents($variable);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                $this->setVariable($key, $base64);
            }
        }
    }

    /**
     * @param Template|Message $model
     * @return string
     */
    public function parseParams($model)
    {
        $params = parse_ini_string($model->getParams());

        if ($model instanceof Message) {
            $params = array_merge(parse_ini_string($model->getTemplate()->getParams()), $params);
        }

        $this->setVariables($params);
    }

    /**
     * @param Template|Message $model
     * @return string
     */
    public function render($model)
    {
        $this->parseParams($model);

        if ($model instanceof Template) {
            $body = $model->getBody();
        } else {
            $this->setVariable('content', $model->getMessage());
            $body = $model->getTemplate()->getBody();
        }

        if ($this->isParseImages()) {
            $this->renderImages();
        }

        return $this->parseVariables($body);
    }
}