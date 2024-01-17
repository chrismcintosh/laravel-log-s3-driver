# Laravel S3 Logging Driver

This package provides a logging driver for Laravel applications that allows logs to be written directly to S3 compatible storage in real time.

## Installation

You can install the package via composer:

Add the following to your composer.json file

```
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/chrismcintosh/laravel-log-s3-driver"
        }
    ],
```

`composer require chrismcintosh/laravel-log-s3-driver "dev-main"`

## Configuration

After installing the package, you need to add the following configuration to the `config/logging.php` file channel array

```
    's3Logger' => [
        'driver' => 'custom',
        'via' => \Chrismcintosh\LaravelLogS3Driver\LaravelLogS3Driver::class,
        'disk' => 'INCLUDE YOUR S3 DISKNAME HERE FROM ./config/filesystems.php',
        'mirror_style' => 'single'
    ],
```

## Usage

Once configured you can make this driver your default logging channel in your .env file by changing the log channel to use s3Logger
`LOG_CHANNEL=s3Logger`

Or you can use the channel as needed
`\Log::channel('s3Logger')->info("Test Log");`

## License

The Laravel S3 Logging Driver is open-sourced software licensed under the MIT license.

## Contributing

Please see CONTRIBUTING for details.

## Security

If you discover any security related issues, please email instead of using the issue tracker.

## Credit

All Contributors
Chris Mcintosh
