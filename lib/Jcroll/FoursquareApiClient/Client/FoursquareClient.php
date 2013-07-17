<?php

namespace Jcroll\FoursquareApiClient\Client;

use Guzzle\Common\Collection;
use Guzzle\Plugin\Oauth\OauthPlugin;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;
use Guzzle\Service\Builder\ServiceBuilder;
use Guzzle\Common\Exception\InvalidArgumentException;

class FoursquareClient extends Client
{
    public static function factory($config = array())
    {
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

        $config = Collection::fromConfig($config, $default, $required);

        $client = new self($config->get('base_url'), $config);

        $client->setDefaultOption('query',  array(
            'client_id' => $config['client_id'],
            'client_secret' => $config['client_secret'],
            'v' => '20130707'
        ));

        $client->setDescription(ServiceDescription::factory(__DIR__.'/../Resources/config/client.json'));

        return $client;
    }

    public function addToken($token)
    {
        $config = $this->getDefaultOption('query');
        $config = array_merge(array('oauth_token' => $token), $config);
        $this->setDefaultOption('query', $config);

        return $this;
    }
}