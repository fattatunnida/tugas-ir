<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Tampilkan halaman search dengan hasil pencarian
     */
    public function index(Request $request)
    {
        $query = $request->input('q', '');
        $documents = [];
        $totalFound = 0;
        $retrievalTime = 0;

        // Jika ada query pencarian, lakukan pencarian
        if (!empty($query)) {
            // Catat waktu mulai pencarian
            $startTime = microtime(true);

            // Lakukan pencarian menggunakan whereFullText
            $documents = Document::whereFullText(['title', 'content'], $query)
                ->get()
                ->toArray();

            // Hitung waktu eksekusi dalam milidetik
            $endTime = microtime(true);
            $retrievalTime = round(($endTime - $startTime) * 1000, 2);
            $totalFound = count($documents);
        }

        return view('search', [
            'query' => $query,
            'documents' => $documents,
            'totalFound' => $totalFound,
            'retrievalTime' => $retrievalTime,
        ]);
    }
}
