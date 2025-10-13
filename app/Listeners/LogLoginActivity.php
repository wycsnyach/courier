<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\LogActivity;
use Illuminate\Support\Facades\Http;

class LogLoginActivity
{
    public function handle(Login $event)
    {
        // Log user activity when logging in
        $user = $event->user;
        $ip = request()->ip();
        $country = $this->getCountryByIP($ip);

        LogActivity::create([
            'user_id' => $user->id,
            'login_time' => now(),
            'ip_address' => $ip,
            'country' => $country,
        ]);
    }

    private function getCountryByIP($ip)
    {
        try {
            $response = Http::get("http://ip-api.com/json/{$ip}");
            return $response->json()['country'] ?? 'Unknown';
        } catch (\Exception $e) {
            return 'Unknown';
        }
    }
}
