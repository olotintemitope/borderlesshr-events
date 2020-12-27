<?php


namespace Laztopaz\Controller;


use Exception;
use Laztopaz\Lib\DatabaseConnection;

class BaseController
{
    const EXTENSION = ".php";
    public $db = null;

    public function __construct()
    {
        $this->db = (new DatabaseConnection)->connect();
    }

    public function render($filePath, $variables = [], $print = true)
    {
        $output = NULL;

        $baseViewPath = dirname(__DIR__) . "/../views/" . $filePath . self::EXTENSION;
        $variables['viewPath'] = dirname(__DIR__) . "/../views/";

        if (file_exists($baseViewPath)) {
            // Extract the variables to a local namespace
            extract($variables);

            // Start output buffering
            ob_start();

            // Include the template file
            include $baseViewPath;

            // End buffering and return its contents
            $output = ob_get_clean();
        }
        if ($print) {
            print $output;
        }
        return $output;

    }
}