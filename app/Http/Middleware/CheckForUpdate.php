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
            $response = Http::withoutVerifying()->get('https://api.david-schuchert.de/vmt/version.json');

            if ($response->failed()) {
                return "Die API-Antwort war nicht erfolgreich.";
            }

            $latestVersion = $response->json('version');
            $updateMessage = $response->json('message');

            if (!$latestVersion || !$updateMessage) {
                return "Die API-Antwort ist ungültig.";
            }
            $currentVersion = '1.1.0';
            // Debugging: Protokolliere die Versionsnummern
            Log::info("Current Version: $currentVersion, Latest Version: $latestVersion");

            if (version_compare($currentVersion, $latestVersion, '<')) {
                return $updateMessage;
            } else {
                
            }
        } catch (RequestException $e) {
            return "Die Update-Prüfung konnte nicht durchgeführt werden.";
        } catch (\Exception $e) {
            return "Ein unbekannter Fehler ist aufgetreten: " . $e->getMessage();
        }
    }
}
