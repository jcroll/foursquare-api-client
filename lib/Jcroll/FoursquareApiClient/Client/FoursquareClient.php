<?php

namespace Jcroll\FoursquareApiClient\Client;
use GuzzleHttp\Client;
use GuzzleHttp\Collection;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use \InvalidArgumentException;

class FoursquareClient extends GuzzleClient
{
    static $serviceDescription = NULL;
    public static function factory($config = array())
    {
        if (static::$serviceDescription == NULL) {
            static::$serviceDescription = json_decode(file_get_contents(dirname(__DIR__).'/Resources/config/client.json'), true);
        }

        $default = array('base_url' => 'https://api.foursquare.com/v2/');
        $required = array(
            'client_id',
            'client_secret',
        );

        foreach ($required as $value) {
            if (empty($config[$value])) {
                throw new InvalidArgumentException("Argument '{$value}' must not be blank.");
            }
        }

        $description = new Description(static::$serviceDescription);

        $config = Collection::fromConfig($config, $default, $required);
        $client = new Client(array(
            'base_url' => $config->get('base_url'),
            'query' => array(
                'client_id' => $config['client_id'],
                'client_secret' => $config['client_secret'],
                'v' => '20130707'
            ),
            'defaults' => array('auth' => 'oauth')
        ));
        $oauth = new Oauth1(array(
            'consumer_key' => $config['client_id'],
            'consumer_secret' => $config['client_secret']
        ));
        $client->getEmitter()->attach($oauth);
        return new self($client, $description);
    }

    public function addToken($token)
    {
        $query = $this->getHttpClient()->getDefaultOption('query');
        $query['oauth_token'] = $token;
        $this->getHttpClient()->setDefaultOption('query', $query);

        return $this;
    }
}