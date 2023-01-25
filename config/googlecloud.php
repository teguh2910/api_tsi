<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Google Cloud  configuration
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for Google Cloud
    |
    |
    |
    |
    */

    'project_id'        => env('GOOGLE_CLOUD_PROJECT_ID'),
    'storage_bucket'    => env('GOOGLE_CLOUD_STORAGE_BUCKET'),
    "private_key_id"    => env('PRIVATE_KEY_ID'),
    "private_key"       => env('PRIVATE_KEY'),
    "client_email"      => env('CLIENT_EMAIL'),
    "client_id"         => env('CLIENT_ID'),
    "auth_uri"          => env('AUTH_URI'),
    "token_uri"         => env('TOKEN_URI'),
    "auth_provider_x509_cert_url" => env('AUTH_PROVIDER_X509_CERT_URL'),
    "client_x509_cert_url" => env('CLIENT_X509_CERT_URL')


];
