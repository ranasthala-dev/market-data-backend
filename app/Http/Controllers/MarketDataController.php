<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\PriceAction;
use Carbon\Carbon;
use App\Models\BsePriceAction;

class MarketDataController extends Controller
{

    public function ConvertCsvToJson()
    {
        $fp = fopen(storage_path('app/sec_bhavdata_full_22072024.csv'), 'r');

        $headers = fgetcsv($fp); // Get column headers

        $data = array();
        while (($row = fgetcsv($fp)) !== false) {
            $data[] = array_combine($headers, $row);
        }
        fclose($fp);

        $json = json_encode($data, JSON_PRETTY_PRINT);

        $output_filename = storage_path('app/price_action.json');
        file_put_contents($output_filename, $json);

        return "csv converted to json";
    }

    public function feedMarketData(Request $request)
    {

        $bhav_file = $request->file('file');

        $bhavFilePath = $bhav_file->getRealPath();

        $bhavFile = fopen($bhavFilePath, "r");

        $index = 0;

        $firstline = true;
        while (($data = fgetcsv($bhavFile, 0, ",")) !== FALSE) {


            if (!$firstline) {

                if ($index == 2) {
                    if (PriceAction::where('market_date', Carbon::createFromFormat('d-M-Y', trim($data['2']))->format('Y-m-d'))->exists()) {
                        return 'already data exists';
                    }
                }

                $change = ((float) trim($data['8']) - (float) trim($data['3']));
                $high = (float) trim(Arr::get($data, '5'));
                $low = (float) trim(Arr::get($data, '6'));
                $close = (float) trim(Arr::get($data, '8'));
                $open = (float) trim(Arr::get($data, '4'));

                if ($change > 0) {
                    $cndl_len = $close - $open;
                    $wick_len = $high - $low;
                    $relative_upper = $cndl_len == 0 || $wick_len == 0 ? 0 : ($high - $close) / ($high - $low);
                    $relative_lower = $cndl_len == 0 || $wick_len == 0 ? 0 : ($open - $low) / ($high - $low);
                } else {
                    $cndl_len = $open - $close;
                    $wick_len = $high - $low;
                    $relative_upper = $cndl_len == 0 || $wick_len == 0 ? 0 : ($high - $open) / ($high - $low);
                    $relative_lower = $cndl_len == 0 || $wick_len == 0 ? 0 : ($close - $low) / ($high - $low);
                }

                $change_cent = (((float) trim($data['8']) - (float) trim($data['3'])) / (float) trim($data['3'])) * 100;
                $raw_data[$index] = [
                    'symbol' => trim($data['0']),
                    'series' => trim($data['1']),
                    'market_date' => Carbon::createFromFormat('d-M-Y', trim($data['2']))->format('Y-m-d'),
                    'pre_closed_price' => (float) trim($data['3']),
                    'open_price' => (float) trim(Arr::get($data, '4')),
                    'closed_price' => (float) trim(Arr::get($data, '8')),
                    'high_price' => (float) trim(Arr::get($data, '5')),
                    'low_price' => (float) trim(Arr::get($data, '6')),
                    'change' => (float) $change,
                    'change_in_cent' => (float) $change_cent,
                    'upper_shadow' => (float) $relative_upper * 100,
                    'lower_shadow' => (float) $relative_lower * 100,
                    'upper_shadow' => (float) $relative_upper,
                    'lower_shadow' => (float) $relative_lower,
                    'trade_qnty' => round(Arr::get($data, '10') / 10000000, 4),
                    'del_trade_qnty' => (float) trim(Arr::get($data, '13')),
                    'del_percent' => (float) trim(Arr::get($data, '14')),
                    'no_of_trades' => (float) trim(Arr::get($data, '12')),
                    'turnover' => (float) trim(Arr::get($data, '11'))
                ];
            }

            $firstline = false;

            $index++;
        }

        fclose($bhavFile);

        PriceAction::insert($raw_data);

        return 'Market feeded successfully';

    }

    public function feedHighLow(Request $request)
    {

        $bhav_file = $request->file('file');

        $bhavFilePath = $bhav_file->getRealPath();

        $bhavFile = fopen($bhavFilePath, "r");

        $index = 0;

        $firstline = true;


        $market_date = date("Y-m-d", strtotime($request->input('market_date')));


        while (($data = fgetcsv($bhavFile, 0, ",")) !== FALSE) {

            if ($index > 3) {

                if ($index == 3) {
                    if (!PriceAction::where('market_date', $market_date)->exists()) {
                        return 'Import market data';
                    }
                }

                PriceAction::where('symbol', Arr::get($data, '0'))->whereDate('market_date', $market_date)->update([
                    '52_week_high' => is_numeric(Arr::get($data, '2')) ? round(Arr::get($data, '2'), 3) : null,
                    '52_week_low' => is_numeric(Arr::get($data, '4')) ? round(Arr::get($data, '4'), 3) : null,


                    // '52_week_high' => is_numeric(Arr::get($data, '4')) ? number_format(Arr::get($data, '4'), 6) : null,

                ]);

            }

            $firstline = false;

            $index++;
        }

        fclose($bhavFile);


        return 'Market feeded successfully';

    }


    public function getMarketData(Request $request)
    {

        $searchTerm = $request->input('search_term');

        $exchange = $request->input('exchange');


        $marketDate = $request->input('market_date') ? date("Y-m-d", strtotime($request->input('market_date'))) : null;


        // if ($marketDate->isSaturday()) {
        //     $marketDate = $marketDate->subDay();
        // }

        // if ($marketDate->isSunday()) {
        //     $marketDate = $marketDate->subDay(2);
        // }

        $series = $request->series;
        $table = $searchTerm ? null : $request->input('table', 'order_data');
        $filter = $searchTerm ? null : $request->input('filter');
        $from = $searchTerm ? null : $request->input('from');
        $to = $searchTerm ? null : $request->input('to');
        $volume1 = $searchTerm ? null : $request->input('volume1');
        $volume2 = $searchTerm ? null : $request->input('volume2');
        $upper = $searchTerm ? null : $request->input('upper');
        $lower = $searchTerm ? null : $request->input('lower');
        $delivery1 = $searchTerm ? null : ($request->input('delivery1') ? $request->input('delivery1') : 0);
        $delivery2 = $searchTerm ? null : ($request->input('delivery2') ? $request->input('delivery2') : 100);
        $priceFrom = $searchTerm ? null : $request->input('priceFrom');
        $priceTo = $searchTerm ? null : $request->input('priceTo');

        $defualt_page = $request->type == 'web' ? null : 12;
        $per_page = $request->input('per_page') ?? $defualt_page;

        $orderBy = $searchTerm ? 'trade_qnty' : ($request->input('orderBy') ?: 'trade_qnty');

        $columns = [
            'symbol',
            'series',
            'pre_closed_price',
            'open_price',
            'closed_price',
            'high_price',
            'low_price',
            'change_in_cent',
            'upper_shadow',
            'lower_shadow',
            'trade_qnty',
            // 'turnover',
            // 'del_trade_qnty',
            'del_percent',
            'no_of_trades',
            'change',
            '52_week_low',
            '52_week_high',
        ]; // Define your available columns here

        $selectedColumns = $request->input('columns', $columns); // Get the selected columns from the form submission or default to all columns
        $columnLabels = [
            'symbol' => 'SYMBOL',
            'series' => 'SERIES',
            'pre_closed_price' => 'PREV CLOSE',
            'open_price' => 'OPEN',
            'closed_price' => 'CLOSE',
            'high_price' => 'HIGH',
            'low_price' => 'LOW',
            'change' => 'CHANGE',
            'change_in_cent' => 'CHANGE%',
            'upper_shadow' => 'UPPER',
            'lower_shadow' => 'LOWER',
            'trade_qnty' => 'VolumeInCrs',
            'turnover' => 'TURNOVER',
            'del_trade_qnty' => 'DEL Qnty',
            'del_percent' => 'DEL Percent',
            'no_of_trades' => 'No of Trades',
            '52_week_low' => '52 week low',
            '52_week_high' => '52 week high',
        ];

        $series_bse = [
            'EQ' => 'A',
            'BE' => 'T',
            'SM' => 'X',
            'BZ' => 'Z',
            'ST' => 'XT',
            'All' => null
        ];

        // $market_data = PriceAction::max('trade_qnty');
        // return $market_data;

        if ($exchange == 'NSE') {
            $market_data = PriceAction::whereDate('market_date', $marketDate)->select($selectedColumns);

        } else {
            $series = $series_bse[$series] ?? null;

            $market_data = BsePriceAction::whereDate('market_date', $marketDate)->select($selectedColumns);

        }


        if ($series) {
            $market_data = $market_data->where('series', $series);
        }



        if ($request->input('search_term')) {
            $searchTerm = $request->input('search_term');
            $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~'];
            $searchTerm = str_replace($reservedSymbols, ' ', $searchTerm);
            $searchValues = preg_split('/\s+/', $searchTerm, -1, PREG_SPLIT_NO_EMPTY);

            $market_data = $market_data->where(function ($q) use ($searchValues) {
                foreach ($searchValues as $value) {
                    $q->orWhere('symbol', 'like', "%{$value}%");
                }
            });
        }




        if ($priceFrom) {
            $market_data = $market_data->where('closed_price', '>', $priceFrom);
        }

        if ($priceTo) {
            $market_data = $market_data->where('closed_price', '<', $priceTo);
        }



        if ($series) {
            $market_data = $market_data->where('series', $series);
        }



        if ($volume1) {
            $market_data = $market_data->where('trade_qnty', '>', $volume1);
        }

        if ($volume2) {
            $market_data = $market_data->where('trade_qnty', '<', $volume2);
        }




        if ($upper) {
            $market_data = $market_data->where('upper_shadow', '<', $upper);
        }

        if ($lower) {
            $market_data = $market_data->where('lower_shadow', '<', $lower);
        }



        if ($delivery1 || $delivery2) {
            $market_data = $market_data->where('del_percent', '>', $delivery1)->where('del_percent', '<=', $delivery2);
        }


        if ($from != null) {
            $market_data = $market_data->where('change_in_cent', '>', (float) $request->from);
        }


        if ($to != null) {
            $market_data = $market_data->where('change_in_cent', '<', (float) $request->to);
        }

        if ($request->type == 'web') {
            $market_data = $market_data->orderByDesc($orderBy)->get();
        } else {
            $market_data = $market_data->orderByDesc($orderBy)->paginate($per_page);

        }







        if ($request->type != 'web') {
            return view('market_data', compact('market_data', 'series', 'from', 'to', 'columns', 'selectedColumns', 'columnLabels', 'volume1', 'volume2', 'upper', 'lower', 'delivery1', 'delivery2', 'series', 'searchTerm', 'orderBy', 'priceFrom', 'priceTo', 'marketDate'));
        }

        if ($request->type == 'api') {
            return response()->json($market_data);
        }

        $market_data = [
            // 'currentPage' => $market_data->currentPage(),
            'data' => $market_data
            // 'market_date' => $marketDate,
            // 'total' => $market_data->total(),
            // 'perPage' => $market_data->perPage(),
            // 'lastPage' => $market_data->lastPage(),
            // 'nextPageUrl' => $market_data->nextPageUrl(),
            // 'previousPageUrl' => $market_data->previousPageUrl(),
        ];


        return response()->json($market_data);


    }

    public function getDataset(Request $request)
    {

        $market_data = PriceAction::where('symbol', $request->symbol)->select('closed_price', 'change_in_cent', 'trade_qnty', 'del_percent', 'no_of_trades', 'turnover', 'high_price', 'created_at', 'market_date', 'symbol')->orderBy('market_date', 'desc')->get()->reverse();

        $labels = $market_data->map(function ($item) {
            return Carbon::parse($item->market_date)->format('M j'); // Formats date as "Aug 30", "Sep 1", etc.
        })->values()->all();

        $closed_price = $market_data->pluck('closed_price')->all();
        $change_in_cent = $market_data->pluck('change_in_cent')->all();
        $trade_qnty = $market_data->pluck('trade_qnty')->all();
        $del_percent = $market_data->pluck('del_percent')->all();
        $no_of_trades = $market_data->pluck('no_of_trades')->all();
        $turnover = $market_data->pluck('turnover')->all();
        $high_price = $market_data->pluck('high_price')->all();

        return [
            'closed_price' => $closed_price,
            'change_in_cent' => $change_in_cent,
            'trade_qnty' => $trade_qnty,
            'del_percent' => $del_percent,
            'no_of_trades' => $no_of_trades,
            'turnover' => $turnover,
            'high_price' => $high_price,
            'labels' => $labels,
            'symbol' => $request->symbol
        ];

    }

    public function feedBseMarketData(Request $request)
    {

        $bhav_file = $request->file('file');

        $bhavFilePath = $bhav_file->getRealPath();

        $bhavFile = fopen($bhavFilePath, "r");

        $index = 0;

        $firstline = true;

        $market_date = date("d-m-", strtotime($request->input('market_date')));


        while (($data = fgetcsv($bhavFile, 0, ",")) !== FALSE) {

            if (!$firstline) {

                if ($index == 2) {
                    if (BsePriceAction::where('market_date', Carbon::createFromFormat('Y-m-d', trim($data['0']))->format('Y-m-d'))->exists()) {
                        return 'already data exists';
                    }
                }

                $change = ((float) trim($data['17']) - (float) trim($data['19']));

                if ((float) trim($data['19']) != 0) {

                    $change_cent = (((float) trim($data['17']) - (float) trim($data['19'])) / (float) trim($data['19'])) * 100;
                } else {

                    $change_cent = 0;

                }

                $raw_data[$index] = [
                    'symbol' => $data['7'],
                    'series' => $data['8'],
                    'script_code' => $data['5'],
                    'market_date' => Carbon::createFromFormat('Y-m-d', trim($data['0']))->format('Y-m-d'),
                    'pre_closed_price' => $data['19'],
                    'change' => (float) $change,
                    'change_in_cent' => (float) $change_cent,
                    'open_price' => (float) trim(Arr::get($data, '14')),
                    'closed_price' => (float) trim(Arr::get($data, '17')),
                    'high_price' => (float) trim(Arr::get($data, '15')),
                    'low_price' => (float) trim(Arr::get($data, '16')),
                    'trade_qnty' => round(Arr::get($data, '24') / 10000000, 4),
                    'no_of_trades' => (float) trim(Arr::get($data, '26')),
                    'turnover' => (float) trim(Arr::get($data, '25'))
                ];

            }


            $firstline = false;

            $index++;
        }


        fclose($bhavFile);

        BsePriceAction::insert($raw_data);

        return 'BSE Market feeded successfully';
    }

    public function feedBseDelivery(Request $request)
    {

        $bhav_file = $request->file('file');

        $bhavFilePath = $bhav_file->getRealPath();

        $bhavFile = fopen($bhavFilePath, "r");

        $index = 0;

        $firstline = true;

        $market_date = date("Y-m-d", strtotime($request->input('market_date')));



        while (($data = fgetcsv($bhavFile, 0, "|")) !== FALSE) {

            if (!$firstline) {

                if ($index == 1) {
                    if (!BsePriceAction::where('market_date', $market_date)->exists()) {
                        return 'Import market data';
                    }
                }




                BsePriceAction::where('script_code', Arr::get($data, '1'))->whereDate('market_date', $market_date)->update([
                    'del_trade_qnty' => (float) Arr::get($data, '2'),
                    'del_percent' => (float) Arr::get($data, '6')
                ]);

            }

            $firstline = false;

            $index++;
        }

        fclose($bhavFile);

        return 'Bse deliveries feeded successfully';

    }

}
