<?php

namespace Chrismcintosh\LaravelLogS3Driver;

use Monolog\LogRecord;

class Processor
{

    public function __invoke(array $record): array
    {
        return $record;
    }
}
