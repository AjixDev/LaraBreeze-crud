<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckIP
{
    public function handle(Request $request, Closure $next)
    {
        $ip = $request->ip();

        // Perform a cURL request to obtain the country information of the IP
        $ch = curl_init();
        $apiKey = env('IPSTACK_API_KEY'); // Store your API key in the environment variable located on .env file.
        $url = "http://api.ipstack.com/{$ip}?access_key={$apiKey}";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $country = json_decode($response)->country ?? '';

        /*
        |
        |--------------------------------------------------------------------------
            Adjust your desired state codes to allow access them access to your dashboard
        */
        $userLocalStates = [
            'IL',
        ]; 

        // exclude local IP due to development needs
        if ($ip === '127.0.0.1') {
            return $next($request);
        }
        
        // Check if the country is in $userLocalStates, otherwise deny access
        if (!in_array($country, $userLocalStates)) {
            return abort(403, 'Access Denied');
        }
        
        return $next($request);
    }
}
