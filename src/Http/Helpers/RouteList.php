<?php namespace Fos\Acl\Http\Helpers;

use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;

/**
 * Helper that will return all registred routes.
 * Extracted from route:list artisan command
 *
 * Class RouteList
 * @package Aginev\Helpers
 */

class RouteList
{
    private static $instance;

    /**
     * Application instance
     *
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * The router instance.
     *
     * @var \Illuminate\Routing\Router
     */
    protected $router;

    /**
     * An array of all the registered routes.
     *
     * @var \Illuminate\Routing\RouteCollection
     */
    protected $routes;

    /**
     * The table headers for the command.
     *
     * @var array
     */
    protected $headers = array(
        'Domain', 'Method', 'URI', 'Name', 'Action', 'Middleware'
    );

    private function __construct()
    {
    }

    public function __clone()
    {
        throw new Exception('\Aginev\Helpers\Routes: Clone not alowed!');
    }

    public static function instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new RouteList();
            self::$instance->init();
        }

        return self::$instance;
    }

    public function init()
    {
        $this->app = App::getFacadeApplication();
        $this->router = $this->app->make('router');
        $this->routes = $this->router->getRoutes();
    }

    /**
     * Compile the routes into a displayable format.
     *
     * @return array
     */
    public function getRoutes()
    {
        $results = array();

        foreach ($this->routes as $route) {
            if ($route->getActionName() != 'Closure') {
                $results[] = $this->getRouteInformation($route);
            }
        }

        return Collection::make(array_filter($results));
    }

    /**
     * Get the route information for a given route.
     *
     * @param  \Illuminate\Routing\Route $route
     * @return array
     */
    protected function getRouteInformation(Route $route)
    {
        list($controller, $action) = explode("@", $route->getActionName());

        return [
            'host' => $route->domain(),
            'method' => implode('|', $route->methods()),
            'uri' => $route->uri(),
            'name' => $route->getName(),
            'controller' => $controller,
            'action' => $action,
            'resource' => $route->getActionName(),
            'middleware' => Collection::make($this->getMiddleware($route))
        ];
    }

    /**
     * Get before filters
     *
     * @param  \Illuminate\Routing\Route $route
     * @return string
     */
    protected function getMiddleware($route)
    {
        $middlewares = array_values($route->middleware());

        $middlewares = array_unique(
            array_merge($middlewares, $this->getPatternFilters($route))
        );

        $actionName = $route->getActionName();

        if (!empty($actionName) && $actionName !== 'Closure') {
            $middlewares = array_merge($middlewares, $this->getControllerMiddleware($actionName));
        }

        return $middlewares;
        return implode(',', $middlewares);
    }

    /**
     * Get the middleware for the given Controller@action name.
     *
     * @param  string $actionName
     * @return array
     */
    protected function getControllerMiddleware($actionName)
    {
        $segments = explode('@', $actionName);

        return $this->getControllerMiddlewareFromInstance(
            $this->app->make($segments[0]), $segments[1]
        );
    }

    /**
     * Get the middlewares for the given controller instance and method.
     *
     * @param  \Illuminate\Routing\Controller $controller
     * @param  string $method
     * @return array
     */
    protected function getControllerMiddlewareFromInstance($controller, $method)
    {
        $middleware = $this->router->getMiddleware();

        $results = [];

        foreach ($controller->getMiddleware() as $name => $options) {
            if (!$this->methodExcludedByOptions($method, $options)) {
                $results[$name] = array_get($middleware, $name, $name);
            }
        }

        return $results;
    }

    /**
     * Determine if the given options exclude a particular method.
     *
     * @param  string $method
     * @param  array $options
     * @return bool
     */
    protected function methodExcludedByOptions($method, array $options)
    {
        return (!empty($options['only']) && !in_array($method, (array) $options['only'])) ||
        (!empty($options['except']) && in_array($method, (array) $options['except']));
    }

    /**
     * Get all of the pattern filters matching the route.
     *
     * @param  \Illuminate\Routing\Route $route
     * @return array
     */
    protected function getPatternFilters($route)
    {
        $patterns = array();

        foreach ($route->methods() as $method) {
            // For each method supported by the route we will need to gather up the patterned
            // filters for that method. We will then merge these in with the other filters
            // we have already gathered up then return them back out to these consumers.
            $inner = $this->getMethodPatterns($route->uri(), $method);

            $patterns = array_merge($patterns, array_keys($inner));
        }

        return $patterns;
    }

    /**
     * Get the pattern filters for a given URI and method.
     *
     * @param  string $uri
     * @param  string $method
     * @return array
     */
    protected function getMethodPatterns($uri, $method)
    {
        return $this->router->findPatternFilters(
            Request::create($uri, $method)
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('name', null, InputOption::VALUE_OPTIONAL, 'Filter the routes by name.'),

            array('path', null, InputOption::VALUE_OPTIONAL, 'Filter the routes by path.'),
        );
    }
}
