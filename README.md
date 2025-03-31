# URL Shortening API

## Instructions for running project

1. clone this Laravel Project repository to a server environment with PHP (>8.3), Composer, and database installed (tested with mariadb:10.11).

2. Run `composer update` command to install composer dependencies.

3. Customise the sample `.env.example` file, in the root of the project to match you local configuration settings, renaming the file to `.env`.

4. Run `php artisan migrate` to setup the database locally.

## RESTful Api Endpoints

`api/encode` :

Method: POST

Parameters:

-   longUrl

Example Request Body:

```
{
	"longUrl": "http://blahbfh.co.uk/route/some/extra?and=here_too&more=bar"
}
```

`api/decode` :

Method: GET

Parameters:

-   shortUrl

Example Request Url:

```
https://yoursite.local/api/decode?shortUrl=http://short.est/2HUdkA
```

It may be necessary to encode the URI shortUrl parameter, if your client software does not do this for you.

## Tests

Run `php artisan test` to run all the tests in the test suite.
