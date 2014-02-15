# JcrollFoursquareApiClient

[![Build Status](https://travis-ci.org/jcroll/foursquare-api-client.png)](https://travis-ci.org/jcroll/foursquare-api-client)

Find the [Symfony2 Bundle for this library here](https://github.com/jcroll/foursquare-api-bundle).

## Why?

There is no library currently built to interact with the [foursquare api](https://developer.foursquare.com/) using the fantastic
[Guzzle HTTP Client library](https://github.com/guzzle/guzzle). Guzzle is awesome and supplies a lot of great things
for building web service clients. Guzzle is fully unit tested which allows this library to be a light wrapper around the Guzzle
core. You can read more [about Guzzle here](http://guzzlephp.org/).

## Installation

The JcrollFoursquareApiClient is available on Packagist ([jcroll/foursquare-api-client](https://packagist.org/packages/jcroll/foursquare-api-client))
and as such installable via [Composer](http://getcomposer.org/).

If you do not use Composer, you can grab the code from GitHub, and use any PSR-0 compatible autoloader
(e.g. the [Symfony2 ClassLoader component](https://github.com/symfony/ClassLoader)) to load the library's classes.

### Composer example

Add JcrollFoursquareApiBundle in your composer.json:

```js
{
    "require": {
        "jcroll/foursquare-api-client": "1.0.*"
    }
}
```

Download the library:

``` bash
$ php composer.phar update jcroll/foursquare-api-client
```

After installing, you need to require Composer's autoloader somewhere in your code:

```php
require_once 'vendor/autoload.php';
```

## Usage

```php
use Jcroll\FoursquareApiClient\Client\FoursquareClient;

$client = FoursquareClient::factory(array(
    'client_id'     => 'your_foursquare_client_id',    // required
    'client_secret' => 'your_foursquare_client_secret' // required
));
$client->addToken($oauthToken); // optionaly pass in for user specific requests
$command = $client->getCommand('venues/search', array(
    'near' => 'Chicago, IL',
    'query' => 'sushi'
));
$results = $command->execute(); // returns an array of results
```

You can find a list of the client's available commands in the bundle's
[client.json](https://github.com/jcroll/foursquare-api-client/blob/master/lib/Jcroll/FoursquareApiClient/Resources/config/client.json) but basically
they should be the same as the [api endpoints listed in the docs](https://developer.foursquare.com/docs/).

## Oauth Integration

Endpoints in the foursquare API that are user specific will require authorization with foursquare using the Oauth 2.0 protocol. This type
of authorization is beyond the scope of this library as there are better libraries for that such as the [FriendsOfSymfony Oauth2 
Server](https://github.com/FriendsOfSymfony/oauth2-php). After authorization you can pass the access token into the client for user 
specific access.
