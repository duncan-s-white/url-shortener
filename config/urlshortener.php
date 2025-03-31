<?php

return [

  /*
    |--------------------------------------------------------------------------
    | Url Shortener Domain
    |--------------------------------------------------------------------------
    |
    | Set this config option to be the domain you wish to use for your domain  
    | shortening service. It will be prefixed to the returned shortUrl
    |
    */

  'domain' => env('URL_SHORTENER_DOMAIN', 'http://short.est/'),

];
