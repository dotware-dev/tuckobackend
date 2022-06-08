<?php
namespace Core;

abstract class Controller
{
    /**
     * Parameters from the matched route
     * @var array
     */
    protected $route_params = [];

    public function __construct($route_params)
    {
        $this->route_params = $route_params;
    }

    public function __call($name, $args)
    {
        $method = $name . 'Action';

        /**
         * Magic method called when a non-existent or inaccessible method is
         * called on an object of this class. Used to execute before and after
         * filter methods on action methods. Action methods need to be named
         * with an "Action" suffix, e.g. indexAction, showAction etc.
         *
         * @param string $name  Method name
         * @param array $args Arguments passed to the method
         *
         * @return void
         */

        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            } else {
                $this->redirect();
            }
        } else {
            throw new \Exception("Method $method not found in controller " . get_class($this));
        }
    }

    /**
     * Before filter - called before an action method.
     *
     * @return boolean
     */
    protected function before()
    {
        switch (true) {
            case (isset($this->route_params['access']) && isset($_SESSION['role']) && ((is_array($this->route_params['access']))?in_array($_SESSION['role'], $this->route_params['access']):$this->route_params['access']==$_SESSION['role']))?true:false:
                $returnValue= true;
                break;
            case (isset($this->route_params['access'])&&((is_array($this->route_params['access']))?in_array("public", $this->route_params['access']):$this->route_params['access']=="public"))?true:false:
                $returnValue= true;
                break;
            
            default:
                $returnValue= false;
                break;
        }

        if ($this->route_params['logged']) {
            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                $returnValue= true;
            } else {
                $returnValue= false;
            }
        }

        return $returnValue;
    }

    /**
     * After filter - called after an action method.
     *
     * @return void
     */
    protected function after()
    {
    }

    public function redirect($direction="login")
    {
        $protocol=null;
        if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
            $protocol = 'https://';
        } else {
            $protocol = 'http://';
        }
        header('Location: ' . $protocol . $_SERVER['HTTP_HOST'] . '/myownframeworklogin/'.$direction, true, 303);
        exit;
    }
}
