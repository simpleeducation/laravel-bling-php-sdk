<?php

namespace Bling\Services;

use Bling\Core\Client;
use Bling\Core\Config;
use Bling\Core\Connect;
use Bling\Core\Response;

class Base
{
    protected $filters = [];
    protected $parameters = [];
    protected $body = [];
    protected $responseType = 'json';
    protected $connect;

    public function __construct()
    {
        $this->connect = Connect::getInstance(
            Client::getInstance(Config::configure(config('bling'))),
            new Response()
        );
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * @param array $filters
     */
    public function setFilters(array $filters): void
    {
        $this->filters = $filters;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     */
    public function setParameters(array $parameters): void
    {
        $this->parameters = $parameters;
    }

    /**
     * @return array
     */
    public function getBody(): array
    {
        return $this->body;
    }

    /**
     * @param array $body
     */
    public function setBody(array $body): void
    {
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getResponseType(): string
    {
        return '/' . ltrim($this->responseType, '/');
    }

    /**
     * @param string $responseType
     */
    public function setResponseType(string $responseType): void
    {
        $this->responseType = $responseType;
    }

    /**
     * @return array
     */
    public function getMergedParameters(): array
    {
        return $this->parameters + $this->body + $this->filters;
    }
}
