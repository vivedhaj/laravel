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
        $response = ImportService::importQuotes(TRUE);
        if (!$response) {
            abort(400, 'Bad request');
        }
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
        $response = ImportService::importQuotes(FALSE);
        if ($response) {
            Quote::oldest()->first()->delete();
        }
        $jsonResponse = Quote::all()->map(function ($quote) {
            return new QuoteResource($quote);
        });
        return response()->json($jsonResponse);
    }

}

