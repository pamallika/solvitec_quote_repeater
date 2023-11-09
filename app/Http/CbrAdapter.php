<?php

namespace App\Http;

use App\Http\Controllers\XmlAdapterInterface;
use SimpleXMLElement;

class CbrAdapter implements XmlAdapterInterface
{
    public static function parse(SimpleXMLElement $xml): array
    {
        $result['date'] = (string)$xml->attributes()['Date'];
        $result['name'] = (string)$xml->attributes()['name'];
        foreach ($xml as $valute) {
            $result['valutes'][] = $valute;
        }
        $result['valutes'] = json_encode($result['valutes']);

        return $result;
    }
}
