<?php

namespace Jcroll\FoursquareApiClient\Client;
use GuzzleHttp\Client;
use GuzzleHttp\Collection;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use GuzzleHttp\Event\BeforeEvent;
use \InvalidArgumentException;

class FoursquareClient extends GuzzleClient
{
    static $serviceDescription = NULL;
    private $httpClient = NULL;
    public static function factory($config = array())
    {
        if (static::$serviceDescription == NULL) {
            static::$serviceDescription = json_decode(file_get_contents(dirname(__DIR__).'/Resources/config/client.json'), true);
        }

//        static::$serviceDescription['base_url'] = 'https://api.foursquare.com/v2/';

        $default = array(
            'verify' => true,
            'event.before' => array(),
            'event.after' => array()
        );

        $required = array(
            'client_id',
            'client_secret'
        );

        foreach ($required as $value) {
            if (empty($config[$value])) {
                throw new InvalidArgumentException("Argument '{$value}' must not be blank.");
            }
        }


        $description = new Description(static::$serviceDescription);

        $config = Collection::fromConfig($config, $default, $required);

        $httpClient = new Client(array(
            'defaults' => array(
                'query' => array(
                    'client_id' => $config['client_id'],
                    'client_secret' => $config['client_secret'],
                    'v' => '20130707'
                ),
                'verify' => $config['verify']
            )
        ));

        if (is_callable($config['event.before']))
            $httpClient->getEmitter()->on('before', $config['event.before']);

        if (is_callable($config['event.complete']))
            $httpClient->getEmitter()->on('complete', $config['event.complete']);

        if (is_callable($config['event.error']))
            $httpClient->getEmitter()->on('error', $config['event.error']);

//        $oauth = new Oauth1(array(
//            'consumer_key' => $config['client_id'],
//            'consumer_secret' => $config['client_secret']
//        ));
//         $httpClient->getEmitter()->attach($oauth);

        return new self($httpClient, $description);
    }

    public function addToken($token)
    {
        $query = $this->getHttpClient()->getDefaultOption('query');
        $query['oauth_token'] = $token;
        $this->getHttpClient()->setDefaultOption('query', $query);

        return $this;
    }
}
