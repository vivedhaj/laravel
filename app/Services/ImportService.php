<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Quote;

class ImportService
{
    /**
     * Imports data from the url
     *
     * @param bool $multiple
     * @return void
     */
    public static function importQuotes($multiple)
    {
        $path = $multiple ? config('constants.multiple_quotes_import_path') : config('constants.single_quote_import_path');
        $response = Http::get($path);
        $rawDatas = json_decode($response->body(), true);
        foreach ($rawDatas as $data) {
            Quote::create([
                'text' => $data['quote'],
                'image_path' => $data['image']
            ]);
        }
    }
}
