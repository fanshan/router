<?php

namespace ObjectivePHP\Router;

use ObjectivePHP\Application\ApplicationInterface;
use ObjectivePHP\Application\Middleware\AbstractMiddleware;
use ObjectivePHP\Primitives\Collection\Collection;


/**
 * Class MetaRouter
 * @package ObjectivePHP\Router
 */
class MetaRouter extends AbstractMiddleware
{

    /**
     * @var Collection
     */
    protected $routers;

    public function __construct($routers = [])
    {
        $this->routers = Collection::cast($routers);
    }


    /**
     * @param RouterInterface $router
     */
    public function register(RouterInterface $router)
    {
        $this->routers->append($router); 
    }

    /**
     * @return Collection
     */
    public function getRegisteredRouters()
    {
        return $this->routers;
    }

    /**
     * @param ApplicationInterface $app
     * @throws Exception
     */
    public function run(ApplicationInterface $app)
    {
        if(!$this->routers)
        {
            throw new Exception('Unable to route request: no router has been registered');
        }


        $matchedRoute = null;
        
        /** @var RouterInterface $router */
        foreach($this->routers as $router) 
        {
            $routingResult = $router->route($app);
            
            if($routingResult->didMatch())
            {
                $matchedRoute = $routingResult->getMatchedRoute();
                break;
            }
        }
        
        if(is_null($matchedRoute))
        {
            throw new Exception('Unable to route request: no route matched requested URL');
        }
        
        $app->getRequest()->setMatchedRoute($matchedRoute);
    }
}