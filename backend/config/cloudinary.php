<?php

/*
 * This file is part of the Laravel Cloudinary package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Cloudinary Configuration
    |--------------------------------------------------------------------------
    |
    | An HTTP or HTTPS URL to notify your application (a webhook) when the process of uploads, deletes, and any API
    | that accepts notification_url has completed.
    |
    |
    */
    'notification_url' => env('CLOUDINARY_NOTIFICATION_URL'),

    /*
    |--------------------------------------------------------------------------
    | Cloudinary Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your Cloudinary settings. Cloudinary is a cloud service that offers a solution to a web
    | application's entire image management pipeline. Easily upload images to the cloud. Automatically perform smart
    | image resizing, cropping and conversion without installing any complex software.
    |
    */

    'cloud_url' => env('CLOUDINARY_URL'),

    /**
     * Upload Preset
     *
     * Upload presets allow you to define the default behavior for your uploads, instead of receiving these as
     * parameters during the upload request itself. Upload presets have precedence over client-side upload
     * parameters.
     */
    'upload_preset' => env('CLOUDINARY_UPLOAD_PRESET'),

    /*
    |--------------------------------------------------------------------------
    | Cloudinary Cloud Name
    |--------------------------------------------------------------------------
    |
    | This is your Cloudinary cloud name. You can find it in your Cloudinary dashboard.
    |
    */
    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),

    /*
    |--------------------------------------------------------------------------
    | Cloudinary API Key
    |--------------------------------------------------------------------------
    |
    | This is your Cloudinary API key. You can find it in your Cloudinary dashboard.
    |
    */
    'api_key' => env('CLOUDINARY_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Cloudinary API Secret
    |--------------------------------------------------------------------------
    |
    | This is your Cloudinary API secret. You can find it in your Cloudinary dashboard.
    |
    */
    'api_secret' => env('CLOUDINARY_API_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Cloudinary Secure URL
    |--------------------------------------------------------------------------
    |
    | This configuration parameter allows you to force HTTPS URLs for all assets, even if they are embedded in non-secure
    | HTTP pages.
    |
    */
    'secure_url' => env('CLOUDINARY_SECURE_URL', true),

    /*
    |--------------------------------------------------------------------------
    | Cloudinary Secure Distribution
    |--------------------------------------------------------------------------
    |
    | This configuration parameter allows you to use a custom domain for your secure URLs.
    |
    */
    'secure_distribution' => env('CLOUDINARY_SECURE_DISTRIBUTION'),

    /*
    |--------------------------------------------------------------------------
    | Cloudinary Private CDN
    |--------------------------------------------------------------------------
    |
    | This configuration parameter allows you to use a private CDN distribution.
    |
    */
    'private_cdn' => env('CLOUDINARY_PRIVATE_CDN'),
];
