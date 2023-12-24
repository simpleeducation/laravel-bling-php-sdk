<?php

namespace Bling\Services;

use Bling\Helpers\XMLBody;
use Bling\Helpers\Body;
use Bling\Helpers\XMLOrderBody;

class Order extends Base
{
    private $numero = '';

    /**
     * @return string
     */
    public function getNumero(): string
    {
        return ($this->numero ? '/' : '') . ltrim($this->numero, '/');
    }

    /**
     * @param string $numero
     */
    public function setNumero(string $numero): void
    {
        $this->numero = $numero;
    }

    /**
     * @param array $body
     */
    public function setBody(array $body): void
    {
        $this->body = ['xml' => (new Body(new XMLOrderBody('pedido')))->setBody($body)];
    }

    /**
     * Método criado para podermos pegar o XML e enviar para o Bling para emitir aNF
     *
     * @return string
     */
    public function getXml()
    {
        return $this->body['xml'];
    }

    public function all()
    {
        return $this->connect
            ->execute('get', $this->getMergedParameters(), "pedidos{$this->getResponseType()}");
    }

    public function get()
    {
        return $this->connect
            ->execute('get', $this->getMergedParameters(), "pedido{$this->getNumero()}{$this->getResponseType()}");
    }

    public function store()
    {
        return $this->connect
            ->execute('post', $this->getMergedParameters(), "pedido{$this->getResponseType()}/");
    }

    public function update()
    {
        return $this->connect
            ->execute('put', $this->getMergedParameters(), "pedido{$this->getNumero()}{$this->getResponseType()}/");
    }
}
