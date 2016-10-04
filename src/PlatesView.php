<?php
/**
 * Slim Framework (http://slimframework.com)
 *
 * @link      https://github.com/kadevland/Slim/Plate
 * @copyright Copyright (c) 2016 kadevland
 * @license   (MIT License)
 */

namespace Kaosland\Slim\Plates\Views;

use Psr\Http\Message\ResponseInterface;
use League\Plates\Engine as Engine;

/**
 * Plate View
 *
 * This class is a Slim Framework view helper built
 * on top of the Plates templating component.
 * Plates is a native PHP template system that’s fast, easy to use and easy
 * to extend. It’s inspired by the excellent Twig
 *
 * @link http://platesphp.com/
 */
class PlatesView implements \ArrayAccess
{

    /**
     * Engine of Plates instance
     * @var League\Plates\Engine
     */
    protected $engine;

    /**
     * Default view variables
     *
     * @var array
     */
    protected $defaultVariables = [];

    /********************************************************************************
     * Constructors and service provider registration
     *******************************************************************************/

    /**
     * Create new Plates instance.
     * @param string $directory
     * @param string $fileExtension
     */
    public function __construct($directory = null, $fileExtension = 'php')
    {
        $this->engine= new Engine($directory, $fileExtension);
    }


    /**
     * Fetch rendered template
     *
     * @param  string $template Template pathname relative to templates directory
     * @param  array  $data     Associative array of template variables
     *
     * @return string
     */
    public function fetch($template, $data = [])
    {
            $data = array_merge($this->defaultVariables, $data);
            return $this->engine->render($template, $data);
    }

    /**
     * Output rendered template.
     *
     * @param ResponseInterface $response
     * @param string            $template Template pathname relative to templates directory
     * @param array             $data     Associative array of template variables
     *
     * @return ResponseInterface
     */
    public function render(ResponseInterface $response, $template, $data = [])
    {
        $response->getBody()->write($this->fetch($template, $data));

        return $response;
    }


    /********************************************************************************
     * Accessors
     *******************************************************************************/

    /**
     * return Engine Plates
     * @return League\Plates\Engine
     */
    public function getEngine()
    {

        return $this->engine;
    }

    /**
     * Check if a template exists.
     * @param  string  $name
     * @return boolean
     */
    public function exists($name)
    {
        return $this->engine->exists($name);
    }


    /**
     * Set path to templates directory.
     * @param  string|null $directory Pass null to disable the default directory.
     * @return Engine
     */
    public function setDirectory($directory)
    {
        return $this->engine->setDirectory($directory);
    }

    /**
     *  Accessor magic to methode of Engine
     * @param  strinf $method of Engine
     * @param  mixe $args
     * @return mixe return of methode Engine called
     */
    public function __call($method, $args)
    {
        if (method_exists($this->engine, $method)&& is_callable(array($this->engine, $method))) {
            return call_user_func_array(array($this->engine,$method), $args);
        }
    }


    /********************************************************************************
     * ArrayAccess interface
     *******************************************************************************/

    /**
     * Does this collection have a given key?
     *
     * @param  string $key The data key
     *
     * @return bool
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->defaultVariables);
    }

    /**
     * Get collection item for key
     *
     * @param string $key The data key
     *
     * @return mixed The key's value, or the default value
     */
    public function offsetGet($key)
    {
        return $this->defaultVariables[$key];
    }

    /**
     * Set collection item
     *
     * @param string $key   The data key
     * @param mixed  $value The data value
     */
    public function offsetSet($key, $value)
    {
        $this->defaultVariables[$key] = $value;
    }

    /**
     * Remove item from collection
     *
     * @param string $key The data key
     */
    public function offsetUnset($key)
    {
        unset($this->defaultVariables[$key]);
    }

    /********************************************************************************
     * Countable interface
     *******************************************************************************/

    /**
     * Get number of items in collection
     *
     * @return int
     */
    public function count()
    {
        return count($this->defaultVariables);
    }

    /********************************************************************************
     * IteratorAggregate interface
     *******************************************************************************/

    /**
     * Get collection iterator
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->defaultVariables);
    }
}
