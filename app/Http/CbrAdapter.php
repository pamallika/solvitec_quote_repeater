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
            $result['valutes'][] = [
                'num_code' => (string)$valute->NumCode,
                'char_code' => (string)$valute->CharCode,
                'name' => (string)$valute->Name,
                'value' => (string)$valute->Value,
                'vunit_rate' => (string)$valute->VunitRate,
            ];
        }

        return $result;
    }
}
