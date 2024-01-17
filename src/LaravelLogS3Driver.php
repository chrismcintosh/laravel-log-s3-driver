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
            $disk = $config['disk'],
            $style = $config['mirror_style']
        );
        $processor = new Processor();
        $logger->pushHandler($handler);
        $logger->pushProcessor($processor);
        return $logger;
    }
}