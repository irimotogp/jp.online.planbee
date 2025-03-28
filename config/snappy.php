<?php

    /*
    |--------------------------------------------------------------------------
    | Snappy PDF / Image Configuration
    |--------------------------------------------------------------------------
    |
    | This option contains settings for PDF generation.
    |
    | Enabled:
    |    
    |    Whether to load PDF / Image generation.
    |
    | Binary:
    |    
    |    The file path of the wkhtmltopdf / wkhtmltoimage executable.
    |
    | Timout:
    |    
    |    The amount of time to wait (in seconds) before PDF / Image generation is stopped.
    |    Setting this to false disables the timeout (unlimited processing time).
    |
    | Options:
    |
    |    The wkhtmltopdf command options. These are passed directly to wkhtmltopdf.
    |    See https://wkhtmltopdf.org/usage/wkhtmltopdf.txt for all options.
    |
    | Env:
    |
    |    The environment variables to set while running the wkhtmltopdf process.
    |
    */
    
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    return [
        'pdf' => [
            'enabled' => true,
            'binary' => base_path('vendor\wemersonjanuario\wkhtmltopdf-windows\bin\64bit\wkhtmltopdf'),
            'timeout' => false,
            'options' => [],
            'env'     => [],
        ],
        
        'image' => [
            'enabled' => true,
            'binary' => 'vendor\wemersonjanuario\wkhtmltopdf-windows\bin\64bit\wkhtmltoimage',
            'timeout' => false,
            'options' => [],
            'env'     => [],
        ],

    ];

} else {
    return [
        'pdf' => array(
            'enabled' => true,
            'binary' => '/usr/local/bin/wkhtmltopdf-amd64',
            'timeout' => false,
            'options' => array(),
            'env' => array(),
        ),
        'image' => array(
            'enabled' => true,
            'binary' => '/usr/local/bin/wkhtmltoimage-amd64',
            'timeout' => false,
            'options' => array(),
            'env' => array(),
        ),
    ];
}