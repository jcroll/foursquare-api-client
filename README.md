# JcrollFoursquareApiClient

[![Build Status](https://travis-ci.org/jcroll/foursquare-api-client.png)](https://travis-ci.org/jcroll/foursquare-api-client)
[![Total Downloads](https://poser.pugx.org/jcroll/foursquare-api-client/downloads)](https://packagist.org/packages/jcroll/foursquare-api-client)
[![Monthly Downloads](https://poser.pugx.org/jcroll/foursquare-api-client/d/monthly)](https://packagist.org/packages/jcroll/foursquare-api-client)
[![Latest Stable Version](https://poser.pugx.org/jcroll/foursquare-api-client/v/stable)](https://packagist.org/packages/jcroll/foursquare-api-client)
[![License](https://poser.pugx.org/jcroll/foursquare-api-client/license)](https://packagist.org/packages/jcroll/foursquare-api-client)

Find the [Symfony Bundle for this library here](https://github.com/jcroll/foursquare-api-bundle).

## Why?

There is no library currently built to interact with the [foursquare api](https://developer.foursquare.com/) using the fantastic
[Guzzle HTTP Client library](https://github.com/guzzle/guzzle). Guzzle is awesome and supplies a lot of great things
for building web service clients. Guzzle is fully unit tested which allows this library to be a light wrapper around the Guzzle
core. You can read more [about Guzzle here](http://guzzlephp.org/).

## Installation

The JcrollFoursquareApiClient is available on Packagist ([jcroll/foursquare-api-client](https://packagist.org/packages/jcroll/foursquare-api-client))
and as such installable via [Composer](http://getcomposer.org/).

If you do not use Composer, you can grab the code from GitHub, and use any PSR-4 compatible autoloader
(e.g. the [Symfony ClassLoader component](https://github.com/symfony/ClassLoader)) to load the library's classes.

### Guzzle Versioning

This package is compatible with different versions of Guzzle (see below):

| Guzzle Version | Foursquare Client Version |
|----------------|---------------------------|
| ~3             | ~1                        |
| ~4, ~5         | ~2                        |
| ~6             | ~3                        |

### Composer example

Add JcrollFoursquareApiBundle in your composer.json:

```js
{
    "require": {
        "jcroll/foursquare-api-client": "~3"
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

$client = FoursquareClient::factory([
    'client_id'     => 'your_foursquare_client_id',     // required
    'client_secret' => 'your_foursquare_client_secret', // required
    'version'       => 20140806,                        // optional
    'mode'          => 'foursquare',                    // optional (one of 'foursquare' or 'swarm')
]);

$client->setToken($oauthToken);  // optionally pass in for user specific requests

$client->setMode('swarm');       // switch from mode 'foursquare' to 'swarm'

$command = $client->getCommand('venues/search', [
    'near'  => 'Chicago, IL',
    'query' => 'sushi'
]);

$results = (array) $client->execute($command); // returns an array of results
```

You can find a list of the client's available commands in the bundle's
[client.json](https://github.com/jcroll/foursquare-api-client/tree/master/src/Resources/config/20160901/client.json) but 
basically they should be the same as the [api endpoints listed in the docs](https://developer.foursquare.com/docs/).

## Oauth Integration

Endpoints in the foursquare API that are user specific will require authorization with foursquare using the Oauth 2.0 
protocol. 

If you're using the [HWIOAuthBundle](https://github.com/hwi/HWIOAuthBundle) with Symfony you can install the 
[JcrollFoursquareApiBundle](https://github.com/jcroll/foursquare-api-bundle) for automatic integration with your
oauth requests.

Otherwise oauth protocol authorization is beyond the scope of this library but you can find a list of possible
libraries [here](https://packagist.org/search/?q=oauth). After authorization you can pass the access token into the 
client for user specific access.
