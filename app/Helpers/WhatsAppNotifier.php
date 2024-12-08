<?php

namespace App\Helpers;

use GuzzleHttp\Client;

class WhatsAppNotifier
{

    public static function sendNotification($phoneNumber, $message)
    {
        $client = new Client();
        $apiKey = env('FONTE_API_KEY'); // Simpan API key di .env
        $url = 'https://api.fonnte.com/send';

        try {
            $response = $client->post($url, [
                'headers' => [
                    'Authorization' => $apiKey
                ],
                'form_params' => [
                    'target' => $phoneNumber,
                    'message' => $message,
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            // Log error jika gagal
            \Log::error('Fonnte API Error: ' . $e->getMessage());
            return false;
        }
    }
}
