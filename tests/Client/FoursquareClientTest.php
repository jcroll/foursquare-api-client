<?php

namespace Jcroll\FoursquareApiClient\Tests\Client;

use Jcroll\FoursquareApiClient\Client\FoursquareClient;

class FoursquareClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param $clientId
     * @param $clientSecret
     *
     * @dataProvider provideConfigValues
     */
    public function testFactoryReturnsClient($clientId, $clientSecret)
    {
        $config = array(
            'client_id' => $clientId,
            'client_secret' => $clientSecret
        );

        $client = FoursquareClient::factory($config);
        $defaultOptions = $client->getDefaultOption('query');

        $this->assertInstanceOf('\\Jcroll\\FoursquareApiClient\\Client\\FoursquareClient', $client);
        $this->assertEquals($config['client_id'], $defaultOptions['client_id']);
        $this->assertEquals($config['client_secret'], $defaultOptions['client_secret']);
    }

    /**
     * @expectedException \Guzzle\Common\Exception\InvalidArgumentException
     */
    public function testFactoryReturnsExceptionOnNullArguments()
    {
        $config = array();

        $client = FoursquareClient::factory($config);
    }

    /**
     * @expectedException \Guzzle\Common\Exception\InvalidArgumentException
     */
    public function testFactoryReturnsExceptionOnBlankArguments()
    {
        $config = array(
            'client_id' => '',
            'client_secret' => ''
        );

        $client = FoursquareClient::factory($config);
    }

    /**
     * @param $clientId
     * @param $clientSecret
     *
     * @dataProvider provideConfigValues
     */
    public function testAddToken($clientId, $clientSecret)
    {
        $config = array(
            'client_id' => $clientId,
            'client_secret' => $clientSecret
        );

        $token = 'secretToken';

        $client = FoursquareClient::factory($config);
        $client->addToken($token);

        $defaultOptions = $client->getDefaultOption('query');

        $this->assertEquals($token, $defaultOptions['oauth_token']);
    }

    public function provideConfigValues()
    {
        return array(
            array('aClientId', 'aClientSecret')
        );
    }
}
