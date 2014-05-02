<?php

class Router {

    /**
     * @var string contains the method of the current request
     */
    private $method;

    /**
     * @var string where the views are stored
     */
    private $viewsFolder = 'views';

    /**
     * Populates the method property
     *
     * Gets the request method from the server super global
     */
    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Gets the method property
     *
     * @return string the current request method
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * Loads the appropriate file
     *
     * Loads the appropriate file based on the current request method. It looks for the file in the views directory and
     * converts the current method into lower case, before trying to add that file.
     * Will throw an exception if the file does not exist.
     *
     * @throws Exception if the file cannot be found
     */
    public function route() {

        // Check the file exists
        if( file_exists( __DIR__ . DIRECTORY_SEPARATOR . $this->viewsFolder . DIRECTORY_SEPARATOR . strtolower( $this->method ) . '.php' ) ) {

            // Load the file
            require_once( __DIR__ . DIRECTORY_SEPARATOR . $this->viewsFolder . DIRECTORY_SEPARATOR . strtolower( $this->method ) . '.php' );

        // File not found, throw exception
        } else {
            throw new Exception('No view found for method ' . $this->method );
        }
    }
}