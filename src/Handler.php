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
    private $log_directory;

    public function __construct($level = Logger::DEBUG, bool $bubble = true, string $disk = 's3', string $style = 'single', string $log_directory = 'logs')
    {
        parent::__construct($level, $bubble);
        $this->disk = $disk;
        $this->style = $style;
        $this->log_directory = $log_directory;
    }

    /**
     * @inheritDoc
     */
    protected function write(array|LogRecord $record): void
    {
        $filename = is_array($record) ? $this->generateFileName($record['datetime']) : $this->generateFileName($record->datetime);
        $filepath = $this->getLogPath($filename);
        $recordFormatted = is_array($record) ? $record['formatted'] : $record->formatted;
        
        if (!Storage::disk($this->disk)->append($filepath, $recordFormatted)) {
            Log::stack(['single'])->info('Tried to log the following message to S3' . PHP_EOL . $recordFormatted);
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
        return "{$this->log_directory}/{$filename}";
    }
}
