<?php

namespace App\Utils;


class FileLogger
{
    protected static ?FileLogger $instance = null;
    protected string $logFile;

    private function __construct(?string $logFile = null)
    {
        $this->logFile = $logFile;
    }

    public static function getInstance(?string $logFile = null)
    {
        if (is_null(self::$instance)) {
            return new self($logFile ?: '/var/custom.log');
        }

        return self::$instance;
    }

    public function log(string $message)
    {
        file_put_contents($this->logFile, $message, FILE_APPEND);
    }
}
