<?php

namespace App\Http\Controllers;

use App\Http\CbrAdapter;
use App\Models\Valute;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use function App\Helpers\errResponse;
use function App\Helpers\okResponse;

class ValuteController extends Controller
{
    protected const CBR_BASE_URI = 'http://www.cbr.ru';

    public function retranslate(Request $request)
    {
        if (!$date = $request->get('date_req')) {
            return errResponse('Param date undefined', ResponseAlias::HTTP_NOT_FOUND);
        }

        $dateCarbon = Carbon::createFromFormat('d/m/Y', $date);
        $formatedDate = $dateCarbon->format('Y-m-d');

        /** @var Valute $valute */
        if ($dateCarbon->isPast() && $valute = Valute::where('date', $formatedDate)->first()) {
            return okResponse($valute->toArray());
        }

        $client = new Client(['base_uri' => self::CBR_BASE_URI]);
        $response = $client->request('GET', '/scripts/XML_daily.asp', ['query' => ['date_req' => $date]]);
        if ($response->getStatusCode() !== ResponseAlias::HTTP_OK) {
            return errResponse('CBR server is not responding, try again later');
        }

        $resultXml = simplexml_load_string($response->getBody());
        if ($resultXml->count() < 1) {
            return errResponse('', ResponseAlias::HTTP_NOT_FOUND);
        }

        $resultData = CbrAdapter::parse($resultXml);

        if ($dateCarbon->isPast()) {
            Valute::create(['name' => $resultData['name'], 'date' => $formatedDate, 'valutes' => $resultData['valutes']]);
        }

        return okResponse($resultData);
    }
}
