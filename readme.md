# Laravel S3 Logging Driver

This package provides a logging driver for Laravel applications that allows logs to be written directly to S3 compatible storage in real time.

## Installation

You can install the package via composer:
`composer require chrismcintosh/laravel-log-s3-driver`

## Configuration

After installing the package, you need to add the following configuration to the `config/logging.php` file channel array

Minimum Configuration

```
    's3Logger' => [
        'driver' => 'custom',
        'via' => \Chrismcintosh\LaravelLogS3Driver\LaravelLogS3Driver::class,
    ],
```

Or Sample Configuration with Options

```
    's3Logger' => [
        'driver' => 'custom',
        'via' => \Chrismcintosh\LaravelLogS3Driver\LaravelLogS3Driver::class,
        'disk' => 's3',
        'mirror_style' => 'single',
        'directory' => 'my/custom/logs/path'
    ],
```

## Configuration Options Explained

### Disk

For this to work you must have an s3 compatible disk defined in ./config/filesystems.php we are looking for the name of the disk here.

- default is `s3`

### Mirror Style

This will work the same way that the normal native single or daily options work in Laravel as you are used to. The key difference is single will append everything to a single `laravel.log` file while daily will name the log file with the current date and append to that.

- Options
  - `single`
  - `daily`

Default is `single`

### Directory

Do you want your logs to be placed in a specific directory in your bucket? Specify that here.

Default is `logs`

## Usage

Once configured you can make this driver your default logging channel in your .env file by changing the log channel to use s3Logger
`LOG_CHANNEL=s3Logger`

Or you can use the channel as needed
`Log::channel('s3Logger')->info("Test Log");`

## Security

If you discover any security related issues, please email instead of using the issue tracker.

## Credit

All Contributors
Chris Mcintosh
