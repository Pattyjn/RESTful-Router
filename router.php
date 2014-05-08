<?php

class Router {

    /**
     * @var string contains the method of the current request
     */
    private $method;

    /**
     * @var string the controller defined in the URL
     */
    private $controller;

    /**
     * @var string where the views are stored
     */
    private $controllersDirectory = 'controllers';

    /**
     * Populates the method property
     *
     * Gets the request method from the server super global
     *
     * Populates the controller if it is set
     */
    public function __construct() {

        $this->method = $_SERVER['REQUEST_METHOD'];

        // If controller not set, kill function
        if ( isset( $_GET['controller'] ) ) {
            $this->controller = $_GET['controller'];
        }
    }

    /**
     * Runs the appropriate controller method
     *
     * Checks to see if there is a controller defined for the controller specified in the URL. Controllers are located
     * in the controllers directory, and the name of the file should match the URL value. Controller class names should
     * be called the file name with "Controller" added to the end, the first character should also be capitalised.
     *
     * If a controller is found, the appropriate method will be called, matching the HTTP request method.
     *
     * Method names are case insensitive, so there is no need to check when checking the appropriate method exists
     * within the controller.
     *
     * @throws Exception if the file cannot be found
     */
    public function route() {

        // Is there a file to handle this controller
        if( !file_exists( __DIR__ . DIRECTORY_SEPARATOR . $this->controllersDirectory . DIRECTORY_SEPARATOR . strtolower( $this->controller ) . '.php' ) ) {
            return; // Controller not found, escape TODO: Handle appropriately
        }

        // load the controller
        require_once( __DIR__ . DIRECTORY_SEPARATOR . $this->controllersDirectory . DIRECTORY_SEPARATOR . strtolower( $this->controller ) . '.php' );

        // Build the controller name
        $controllerName = ucfirst( $this->controller ) . 'Controller';

        // Create a new instance of the controller
        $controller = new $controllerName();

        // Check the controller has a method for the current request type
        if ( method_exists( $controller, $this->method ) ) {

            // Build the method name
            $methodName = $this->method;

            // Call the method
            $controller->$methodName();
        }
    }
}