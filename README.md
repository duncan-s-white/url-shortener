# URL Shortening API

## Instructions for running project

1. Clone this Laravel project repository to a machine with PHP (>8.3), Composer (>2.8.6), and a suitable database to test e.g. SQLite3.

2. Run `composer install` command.

3. Customise the sample `.env.example` file, with any local configuration settings you wish to use, renaming the file to `.env`.

4. Run `php artisan key:generate` to set an application key.

5. Run `php artisan migrate` to set up the database locally.

6. Run `php artisan serve` to run the project locally.

## RESTful Api Endpoints

### `api/encode` :

**Method**: POST

**Parameters**:

-   longUrl

**Example Request Body**:

```
{
	"longUrl": "http://blahbfh.co.uk/route/some/extra?and=here_too&more=bar"
}
```

**Example Response**:

```
{
	"shortUrl": "http:\/\/short.est\/2HUdkA",
	"longUrl": "http:\/\/blahbfh.co.uk\/route\/some\/extra?and=here_too&more=bar"
}
```

### `api/decode` :

**Method**: GET

**Parameters**:

-   shortUrl

**Example Request Url**:

```
http://127.0.0.1:8000/api/decode?shortUrl=http://short.est/2HUdkA
```

It may be necessary to encode the URI shortUrl parameter, if your client software does not do this for you.

**Example Response**:

```
{
	"shortUrl": "http:\/\/short.est\/2HUdkA",
	"longUrl": "http:\/\/blahbfh.co.uk\/route\/some\/extra?and=here_too&more=bar"
}
```

## Tests

Run `php artisan test` to run all the tests in the test suite.
