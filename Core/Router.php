<?php
namespace Core;

    class Router
    {
        //Assosiative array with the routes (the routing table)
        protected $routes=[];
        //Parameters from the matched route
        protected $params=[];
        //Parameters that should not be passed to the action
        protected $not_function_params=['controller','action','namespace','access','method'];

        //Method to add a route to the routing table
        /*
            @param string $route the route URL
            @param string $method the allowed request method
            @param array $params Parameters (controller, action,etc.)
        */
        public function add($route, $access="public", $params=[], $method=["GET","POST"], $logged=false)
        {
            // $this->routes[$route] = $params;
            //Convert route to a regular expression
            $route = preg_replace('/\//', '\\/', $route);

            //Convert variables e.g. {controller}
            $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-zA-Z-]+)', $route);

            //Convert variables with custom regular expressions e. g. {id:\d+}
            $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

            //Add start and end delimiters
            $route = '/^' . $route . '$/i';
            $this->routes[$route] = $params;

            //Making the default method "GET"
            $this->routes[$route]['method']=(isset($method)&&!empty($method))?$method:["GET","POST"];
            $this->routes[$route]['access']=(isset($access)&&!empty($access))?$access:"public";
            $this->routes[$route]['logged']=(isset($logged)&&!empty($logged))?$logged:false;
        }

        //Method to match the requested route with the routes in the routing table, setting the $params property if a route is found
        /*
        @param string $url the url to match
        */

        public function match($url)
        {
            // foreach ($this->routes as $route => $params) {
            //     if ($url == $route) {
            //         switch (true) {
            //             case (isset($params['method'])&&$params['method']==$_SERVER['REQUEST_METHOD'])?true:false:
            //                 $this->params = $params;
            //                 return true;
            //             break;
            //             case (isset($params['method'])&&$params['method']!=$_SERVER['REQUEST_METHOD'])?true:false:
            //                 return false;
            //             break;
            //             default:
            //                 $this->params = $params;
            //                 return true;
            //         }
            //     } else {
            //         return false;
            //     }
            // }
            // return false;
            // $reg_exp="/^(?P<controller>[a-zA-Z0-9]+)\/(?P<action>[a-zA-Z0-9]+)/";
            // if (preg_match($reg_exp, $url, $matches)) {
            //     $params=[];
            //     foreach ($matches as $key => $match) {
            //         if (is_string($key)) {
            //             $params[$key] = $match;
            //         }
            //     }
            //     $this->params=$params;
            //     echo "<pre>";
            //     var_dump($this->params);
            //     var_dump($this->routes);
            //     echo "</pre>";
            //     return true;
            // }
            if (substr($url, -1)=="/") {
                $url = substr($url, 0, -1);
            }

            
            foreach ($this->routes as $route =>$params) {
                /**
                 *Verify if route and request method match
                 */
                if (preg_match($route, $url, $matches)&&((is_array($params['method']))?in_array($_SERVER['REQUEST_METHOD'], $params['method']):$params['method']==$_SERVER['REQUEST_METHOD'])?true:false) {
                    # get named capture group values
                    foreach ($matches as $key => $match) {
                        if (is_string($key)) {
                            $params[$key] = $match;
                        }
                    }
                    if (!isset($params['action'])) {
                        $params['action']='index';
                    }
                    $this->params = $params;
                    return true;
                    // echo "<pre>";
                    // var_dump($this->getParams);
                    // var_dump($this->routes);
                    // echo "</pre>";
                }
            }
            return false;
        }

        public function dispatch($url)
        {
            $url=$this->removeQueryStringVariables($url);
            if ($this->match($url)) {
                $controller = $this->params['controller'];
                $controller = $this->convertToStudlyCaps($controller);
                // $controller="App\Controllers\\$controller";
                $controller=$this->getNamespace().$controller;
                if (class_exists($controller)) {
                    $controller_object = new $controller($this->params);
                    $action=$this->params['action'];
                    $action=$this->convertToCamelCase($action);
                    
                    if (preg_match('/action$/i', $action) == 0) {
                        foreach ($this->params as $key => $param) {
                            if (!in_array($key, $this->not_function_params)) {
                                $action_parameters[$key]=$param;
                            }
                        }
                        if (isset($action_parameters) && !empty($action_parameters)) {
                            $controller_object->$action($action_parameters);
                        } else {
                            $controller_object->$action();
                        }
                    } else {
                        throw new \Exception("Action $action does not exist.", 404);
                    }
                } else {
                    throw new \Exception("Controller class $controller not found", 404);
                }
            } else {
                throw new \Exception('No route matched.', 404);
            }
        }
        

        //Get all the routes from the routing table
        public function getRoutes()
        {
            return $this->routes;
        }

        //Get the currently matched parameters
        public function getParams()
        {
            return $this->params;
        }
        /**
         * Convert the string with hyphens to StudlyCaps,
         * e.g. post-authors => PostAuthors
         *
         * @param string $string The string to convert
         *
         * @return string
         */
        protected function convertToStudlyCaps($string)
        {
            return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
        }

        /**
         * Convert the string with hyphens to camelCase,
         * e.g. add-new => addNew
         *
         * @param string $string The string to convert
         *
         * @return string
         */
        protected function convertToCamelCase($string)
        {
            return lcfirst($this->convertToStudlyCaps($string));
        }

        // /**
        //  * Remove the query string variables from the URL (if any). As the full
        //  * query string is used for the route, any variables at the end will need
        //  * to be removed before the route is matched to the routing table. For
        //  * example:
        //  *
        //  *   URL                           $_SERVER['QUERY_STRING']  Route
        //  *   -------------------------------------------------------------------
        //  *   localhost                     ''                        ''
        //  *   localhost/?                   ''                        ''
        //  *   localhost/?page=1             page=1                    ''
        //  *   localhost/posts?page=1        posts&page=1              posts
        //  *   localhost/posts/index         posts/index               posts/index
        //  *   localhost/posts/index?page=1  posts/index&page=1        posts/index
        //  *
        //  * A URL of the format localhost/?page (one variable name, no value) won't
        //  * work however. (NB. The .htaccess file converts the first ? to a & when
        //  * it's passed through to the $_SERVER variable).
        //  *
        //  * @param string $url The full URL
        //  *
        //  * @return array query variables
        //  */
        // protected function getQueryStringVariables(){
        //     $queryVariables = [];
        //     foreach ($_GET as $key => $value) {
        //         $queryVariables[$key] = $value;
        //     }
        //     array_shift($queryVariables);
        //     return $queryVariables;
        // }

        protected function removeQueryStringVariables($url)
        {
            if ($url != '') {
                $parts = explode('&', $url, 2);

                if (strpos($parts[0], '=') === false) {
                    $url = $parts[0];
                } else {
                    $url = '';
                }
            }

            return $url;
        }

        /**
         * Get the namespace for the controller class. The namespace defined in the
         * route parameters is added if present.
         *
         * @return string The request URL
         */
        protected function getNamespace()
        {
            $namespace = 'App\Controllers\\';

            if (array_key_exists('namespace', $this->params)) {
                $namespace .= $this->params['namespace'] . '\\';
            }

            return $namespace;
        }
    }
