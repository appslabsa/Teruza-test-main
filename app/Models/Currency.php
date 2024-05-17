<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Currency extends Model
{
    use HasFactory;

    public static function getRates()
{
    $response = Http::withOptions(['verify' => 'C:\xampp\apache\bin\cacert.pem'])->get('https://www.completeapi.com/free_currencies.min.json');
        if ($response->successful()) {
            $data = $response->json();
            // Log the API response
            \Log::info('API Response:', $data);
            return $data['forex'];
        }

        return [];
}

}

