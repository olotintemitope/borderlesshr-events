<?php


namespace Laztopaz\Lib;


class BaseController
{
    const EXTENSION = ".php";

    public function render($filePath, $variables = [], $print = true)
    {
        $output = NULL;

        $baseViewPath = dirname(__DIR__) . "/../views/" . $filePath . self::EXTENSION;

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