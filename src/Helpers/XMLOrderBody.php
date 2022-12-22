<?php

namespace Bling\Helpers;

use Bling\Contracts\BodyInterface;

class XMLOrderBody extends XMLBody
{
    public function toXml($array, $rootElement = null, $xml = null)
    {
        $_xml = $xml;

        if ($_xml === null) {
            $_xml = new \SimpleXMLElement($rootElement !== null ? "<{$rootElement}/>" : '<root/>');
        }

        foreach ($array as $k => $v) {

            if('itens' === $k) {

                foreach($v as $tag => $item) {
                    $this->toXml($item, 'item', $_xml->addChild($k));
                }

            } else {

                if (is_array($v)) {
                    $this->toXml($v, $k, $_xml->addChild($k));
                } else {
                    $_xml->addChild($k, $v);
                }
            }

        }

        return $_xml->asXML();
    }
}
