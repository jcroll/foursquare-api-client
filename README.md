# JcrollFoursquareApiClient

[![Build Status](https://travis-ci.org/jcroll/foursquare-api-client.png)](https://travis-ci.org/jcroll/foursquare-api-client)

## Why?

There is no library currently built to interact with the [foursquare api](https://developer.foursquare.com/) using the fantastic
[Guzzle HTTP Client library](https://github.com/guzzle/guzzle). Guzzle is awesome and supplies a lot of great things
for building web service clients. Guzzle is fully unit tested which allows this library to be a light wrapper around the Guzzle
core. You can read more [about Guzzle here](http://guzzlephp.org/).

## Oauth Integration

Endpoints in the foursquare API that are user specific will require authorization with foursquare using the Oauth 2.0 protocal. This type
of authorization is beyond the scope of this library as there are better libraries for that such as the [FriendsOfSymfony Oauth2 
Server](https://github.com/FriendsOfSymfony/oauth2-php). After authorization you can pass the access token into client for user 
specific access.

## Usage

```php
use Jcroll\FoursquareApiClient\Client\FoursquareClient;

$client = FoursquareClient::factory(array(
    'client_id'     => 'your_foursquare_client_id',
    'client_secret' => 'your_foursquare_client_secret'
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


