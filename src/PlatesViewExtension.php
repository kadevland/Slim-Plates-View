<?php
/**
 * Slim Framework (http://slimframework.com)
 *
 * @link      https://github.com/kadevland/Slim/Plate
 * @copyright Copyright (c) 2016 kadevland
 * @license   (MIT License)
 */

namespace Kaosland\Slim\Plates\Views;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class PlatesViewExtension implements ExtensionInterface
{
    /**
     * @var \Slim\Interfaces\RouterInterface
     */
    private $router;

    /**
     * @var string|\Slim\Http\Uri
     */
    private $uri;

    public function __construct($router, $uri)
    {
        $this->router = $router;
        $this->uri = $uri;
    }

    public function register(Engine $engine)
    {
        $engine->registerFunction('path_for', array($this, 'pathFor'));
        $engine->registerFunction('base_url', array($this, 'baseUrl'));
         $engine->registerFunction('is_url', array($this, 'isUrl'));
    }

    public function pathFor($name, $data = [], $queryParams = [], $appName = 'default')
    {
        return $this->router->pathFor($name, $data, $queryParams);
    }

    public function baseUrl()
    {
        if (is_string($this->uri)) {
            return $this->uri;
        }
        if (method_exists($this->uri, 'getBaseUrl')) {
            return $this->uri->getBaseUrl();
        }
    }

    /**
     * Set the base url
     *
     * @param string|Slim\Http\Uri $baseUrl
     * @return void
     */
    public function setBaseUrl($baseUrl)
    {
        $this->uri = $baseUrl;
    }
    
    /**
     * check if  url macth witch Slim\Http\Uri else return null
     *
     * @param string
     * @return booleen if uri defined by Slim\Http\Uri else null
     */	

    public function isUrl($url){
	
	 if (method_exists($this->uri, 'getPath')) {
            return $this->uri->getPath()==$url;
	 }
	
	return null;

    }
	
}
