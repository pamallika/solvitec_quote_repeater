<?php

namespace App\Http\Controllers;

use SimpleXMLElement;

interface XmlAdapterInterface
{
    public static function parse(SimpleXMLElement $xml): array;
}
