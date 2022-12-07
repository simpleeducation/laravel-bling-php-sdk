<?php

namespace Bling\Core;

use Bling\Contracts\RequestInterface;

class Connect
{
    /**
     * @var RequestInterface
     */
    private static $apiClient;

    /**
     * @var Response
     */
    private static $readResponse;

    /**
     * @var instance
     */
    private static $instance;

    private function __construct()
    {
    }

    private function __wakeup()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance(RequestInterface $apiClient, Response $readResponse)
    {
        self::$apiClient    = $apiClient;
        self::$readResponse = $readResponse;

        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Send a request to the api and return the response
     *
     * @param string $method
     * @param array $parameters
     * @param string $url
     * @param bool $customContentType set to true if you have a Content-Type header defined
     * @return string
     * @throws \Exception
     */
    public function execute(
        string $method = "get",
        array $parameters = [],
        string $url = "",
        $customContentType = false
    ) : string {
        if ($customContentType) {
            $response = self::$apiClient->request($method, $url, $parameters);
        } else {
            $queryParameters = $this->getQueryParameters($method, $parameters);
            $response        = self::$apiClient->$method($url, $queryParameters);
        }

        return self::$readResponse->getResponseContents($response);
    }

    /**
     * @param string $method
     * @param array $parameters
     * @return array
     */
    public function getQueryParameters(string $method, array $parameters): array
    {
        switch ($method) {
            case "get":
                return self::$apiClient
                    ->formatGetParameters($parameters + (array) self::$apiClient->getClient()->getConfig('query'));
                break;
            default:
                return self::$apiClient
                    ->formatRequestParameters($parameters + (array) self::$apiClient->getClient()->getConfig('query'));
                break;
        }
    }
}
