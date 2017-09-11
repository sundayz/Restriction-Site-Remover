<?php

abstract class BaseController
{
    /**
     * Twig template data.
     * @var array
     */
    private $templateData;

    /**
     * Constructor adds data available to all templates (effectively global variables).
     */
    public function __construct()
    {
        $this->templateData = array(
            // Any data that belongs to every template.
        );
        $this->before();
    }

    public function __destruct()
    {
        $this->after();
    }

    /**
     * Adds to the Twig template data.
     * @param $key
     * @param $value
     */
    protected function putData($key, $value)
    {
        $this->templateData[$key] = $value;
    }

    /**
     * Renders twig template.
     */
    protected function render(string $templateName)
    {
        if (count( $this->templateData) > 0)
            Flight::view()->display($templateName,  $this->templateData);
        else
            Flight::view()->display($templateName);
    }

    /**
     * Called after the template data is initialised.
     * @return mixed
     */
    abstract protected function before();

    /**
     * Called by the destructor, potentially after render() has been called.
     * @return mixed
     */
    abstract protected function after();
}
