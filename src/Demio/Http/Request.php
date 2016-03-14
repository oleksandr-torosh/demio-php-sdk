<?php

/**
 * @author Oleksandr Torosh <webtorua@gmail.com>
 */
namespace Demio\Http;

use Demio\Injectable;

class Request extends Injectable
{
    protected $base_uri = 'http://my.demio.loc/api/v1/';

    /**
     * @param $endpoint
     * @param array $params
     * @param string $method
     * @return Response
     */
    public function call($endpoint, array $params = [], $method = 'GET')
    {
        $client = new \GuzzleHttp\Client([
            'exceptions' => false,
            'verify'     => false
        ]);
        $response = $client->request($method, $this->base_uri . $endpoint, [
            'headers' => [
                'Api-Key'    => $this->getApiKey(),
                'Api-Secret' => $this->getApiSecret(),
                'Accept'     => 'application/json',
            ],
            'body'    => json_encode($params)
        ]);
        return new Response($response);
    }

    /**
     * @param $endpoint
     * @return Response
     */
    public function get($endpoint)
    {
        return $this->call($endpoint, [], 'GET');
    }

    /**
     * @param $endpoint
     * @param $params
     * @return Response
     */
    public function post($endpoint, $params)
    {
        return $this->call($endpoint, $params, 'POST');
    }

    /**
     * @param $endpoint
     * @param $params
     * @return Response
     */
    public function put($endpoint, $params)
    {
        return $this->call($endpoint, $params, 'PUT');
    }

    /**
     * @param $endpoint
     * @param $params
     * @return Response
     */
    public function delete($endpoint, $params)
    {
        return $this->call($endpoint, $params, 'DELETE');
    }

}