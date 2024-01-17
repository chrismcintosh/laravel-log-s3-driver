<?php

namespace Chrismcintosh\LaravelLogS3Driver;

use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Monolog\Formatter\LineFormatter;
use Monolog\LogRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class Handler extends AbstractProcessingHandler
{
    /**
     * The standard date format to use when writing logs.
     *
     * @var string
     */
    protected $filePathDateFormat = 'Y-m-d';
    protected $dateFormat = 'Y-m-d H:i:s';
    private $disk;
    private $style;

    public function __construct($level = Logger::DEBUG, bool $bubble = true, string $disk = '', string $style = '')
    {
        parent::__construct($level, $bubble);
        $this->disk = $disk;
        $this->style = $style;
    }

    /**
     * @inheritDoc
     */
    protected function write(LogRecord $record): void
    {
        $filename = $this->generateFileName($record->datetime);
        $filepath = $this->getLogPath($filename);

        if (!Storage::disk('b2')->append($filepath, $record->formatted)) {
            Log::stack(['single'])->info('Tried to log the following message to S3' . PHP_EOL . $record->formatted);
        }
    }

    protected function getDefaultFormatter(): FormatterInterface
    {
        return new LineFormatter(null, $this->dateFormat, true, true, true);
    }

    public function generateFileName($datetime): string
    {
        if ($this->style === 'daily') {
            return 'laravel-' . $this->generateDateFileName($datetime) . '.log';
        }

        return "laravel.log";
    }

    public function generateDateFileName($datetime): string
    {
        return Carbon::parse($datetime)->format($this->filePathDateFormat);
    }

    public function getLogPath($filename): string
    {
        return "logs/{$filename}";
    }
}