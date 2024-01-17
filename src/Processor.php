<?php

namespace Chrismcintosh\LaravelLogS3Driver;

use Monolog\LogRecord;

class Processor
{

    public function __invoke(LogRecord $record): LogRecord
    {
        return $record;
    }
}