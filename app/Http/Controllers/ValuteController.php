<?php

namespace App\Http\Controllers;

use App\Http\CbrAdapter;
use App\Models\Quote;
use App\Models\Valute;
use Carbon\Exceptions\InvalidFormatException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Mockery\Exception;
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
        try {
            $dateCarbon = Carbon::createFromFormat('d/m/Y', $date);
        } catch (InvalidFormatException $e) {
            return errResponse('date_req format must be ' . 'd/m/Y ' . $e->getMessage(), ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        }

        $formatedDate = $dateCarbon->format('Y-m-d');

        /** @var Quote $quote */
        if ($dateCarbon->isPast() && $quote = Quote::where('date', $formatedDate)->first()) {
            return okResponse($quote->valutes->toArray());
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

        if ($dateCarbon->isPast() && !$dateCarbon->isToday()) {
            /** @var Quote $quote */
            $quote = Quote::firstOrCreate(['name' => 'asdasd', 'date' => $formatedDate]);
            foreach ($resultData['valutes'] as $valute) {
                $valute['quote_id'] = $quote->getId();
                Valute::create($valute);
            }
        }

        return okResponse($resultData['valutes']);
    }
}
