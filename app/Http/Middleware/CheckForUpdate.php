<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use Log;
use Session;

class CheckForUpdate
{
    public function handle($request, Closure $next)
    {
        $updateMessage = $this->checkForUpdate();
        if (Session::get('updateMessage') !== $updateMessage) {
            Session::put('updateMessage', $updateMessage);
        }

        return $next($request);
    }

    private function checkForUpdate()
    {
        try {
            // Set a low timeout for the update check to prevent blocking the app
            $response = Http::withoutVerifying()
                ->timeout(3)
                ->get('https://api.david-schuchert.de/vmt/version.json');

            if ($response->failed()) {
                return null; // Silent failure if API is offline
            }

            $latestVersion = $response->json('version');
            $updateMessage = $response->json('message');

            if (!$latestVersion || !$updateMessage) {
                return null;
            }

            $currentVersion = '2.2.0';

            if (version_compare($currentVersion, $latestVersion, '<')) {
                return $updateMessage;
            }

            return null;
        } catch (\Exception $e) {
            // Fail silently if API is offline or unreachable
            return null;
        }
    }

}


