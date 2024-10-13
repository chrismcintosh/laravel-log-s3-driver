<?php

namespace Chrismcintosh\LaravelLogS3Driver;

use Monolog\LogRecord;

class Processor
{

    public function __invoke(array|LogRecord $record): array|LogRecord
    {
        return $record;
    }
}
