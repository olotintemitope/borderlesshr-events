<?php


namespace Laztopaz\Lib;


use Dotenv\Dotenv;

class DatabaseConnection extends \Laztopaz\PotatoORM\DatabaseConnection
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Load Dotenv to grant getenv() access to environment variables in .env file.
     */
    public function loadEnv()
    {
        if (! getenv('APP_ENV')) {
            $dotenv = new Dotenv(__DIR__.'/../../');
            $dotenv->load();
        }
    }

}