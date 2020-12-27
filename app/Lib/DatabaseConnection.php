<?php


namespace Laztopaz\Lib;


use Dotenv\Dotenv;
use Exception;
use PDO;

class DatabaseConnection
{
    private $dbConn = null;

    public function __construct()
    {
        $this->loadEnv();

        try {
            $databaseName = getenv('databaseName');
            $databaseHost = getenv('databaseHost');
            $databaseUsername = getenv('databaseUsername');
            $databasePassword = getenv('databasePassword');

            $options = [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ];

            $dsn = 'mysql:host=' . $databaseHost . ';dbname=' . $databaseName; // Set DSN
            $this->dbConn = new PDO($dsn, $databaseUsername, $databasePassword, $options);
        } catch (Exception $exception) {
            throw new $exception();
        }
    }

    /**
     * Load Dotenv to grant getenv() access to environment variables in .env file.
     */
    public function loadEnv()
    {
        if (!getenv('APP_ENV')) {
            $dotenv = new Dotenv(__DIR__ . '/../../');
            $dotenv->load();
        }
    }

    public function connect(): PDO
    {
        return $this->dbConn;
    }

}