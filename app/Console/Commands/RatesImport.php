<?php

namespace App\Console\Commands;

use App\Currency;
use App\Rates;
use App\Services\Api\BankLvRequest;
use App\Services\BankLv\Request;
use App\Services\BankLv\XmlParser;
use Illuminate\Console\Command;

class RatesImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    public function handle(Request $request)
    {
        $parser = new XmlParser($request->getXml());

        $this->save($parser->parse());

        $this->info('rates imported');
    }

    protected function save(array $parsedData)
    {
        foreach ($parsedData['rates'] as $bankRate) {

            $currency = Currency::query()->firstOrCreate(['code' => $bankRate['currency']]);

            $rate = Rates::query()->firstOrNew(['date' => $parsedData['date']->format('Y-m-d'), 'currencyId' => $currency->id]);
            $rate->currencyId = $currency->id;
            $rate->rate = $bankRate['rate'];

            $rate->save();
        }
    }
}
