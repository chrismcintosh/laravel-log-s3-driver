<?php

namespace Chrismcintosh\LaravelLogS3Driver;

use Monolog\Logger;
use Chrismcintosh\LaravelLogS3Driver\Handler;
use Chrismcintosh\LaravelLogS3Driver\Processor;

class LaravelLogS3Driver
{
    /**
     * Create a custom Monolog instance.
     */
    public function __invoke(array $config): Logger
    {
        $environment = config('app.env');

        $logger = new Logger($environment);
        $handler = new Handler(
            $level = Logger::DEBUG,
            $bubble = true,
            $disk = isset($config['disk']) ? $config['disk'] : 's3',
            $style = isset($config['style']) ? $config['style'] : 'single',
            $log_directory = isset($config['log_directory']) ? $config['log_directory'] : 'logs'
        );
        $processor = new Processor();
        $logger->pushHandler($handler);
        $logger->pushProcessor($processor);
        return $logger;
    }
}