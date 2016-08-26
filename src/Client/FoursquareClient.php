<?php

namespace Jcroll\FoursquareApiClient\Client;

use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use GuzzleHttp\Client;

class FoursquareClient extends GuzzleClient
{
    /**
     * {@inheritdoc}
     */
    public static function factory($config = [])
    {
        $required = ['client_id', 'client_secret'];

        foreach ($required as $value) {
            if (!isset($config[$value]) || !$config[$value]) {
                throw new \InvalidArgumentException(sprintf('Argument "%s" is required.', $value));
            }
        }

        $client = new Client([
            'base_url' => 'https://api.foursquare.com/v2/',
            'defaults' => [
                'query' => [
                    'client_id'     => $config['client_id'],
                    'client_secret' => $config['client_secret'],
                    'v'             => '20130707'
                ],
            ]
        ]);

        $contents    = file_get_contents(sprintf('%s/../Resources/config/client.json', __DIR__));
        $description = new Description(json_decode($contents, true));

        return new static($client, $description);
    }

    /**
     * @param string $token
     *
     * @return $this
     */
    public function addToken($token)
    {
        $query = $this->getHttpClient()->getDefaultOption('query');
        $query['oauth_token'] = $token;
        $this->getHttpClient()->setDefaultOption('query', $query);

        return $this;
    }
}