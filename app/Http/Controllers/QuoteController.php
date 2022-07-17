<?php

namespace App\Http\Controllers;
use App\Models\Quote;
use App\Services\ImportService;
use Illuminate\Http\Request;
use App\Http\Resources\QuoteResource;

class QuoteController extends Controller
{
    /**
     * Imports & lists 5 quotes.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function loadQuotes() {
        Quote::truncate();
        ImportService::importQuotes(TRUE);
        $jsonResponse = Quote::all()->map(function ($quote) {
            return new QuoteResource($quote);
        });
        return response()->json($jsonResponse);
    }

    /**
     * retrieves new quote, deletes oldest quote & lists them.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getQuotes(Request $request) {

        Quote::orderBy('created_at', 'asc')
            ->limit(1)
            ->delete();
        ImportService::importQuotes(FALSE);

        $jsonResponse = Quote::all()->map(function ($quote) {
            return new QuoteResource($quote);
        });

        return response()->json($jsonResponse);
    }

}

