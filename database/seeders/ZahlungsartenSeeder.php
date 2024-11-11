<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Zahlungsart;

class ZahlungsartenSeeder extends Seeder
{
    public function run()
    {
        $zahlungsarten = [
            'PayPal',
            'Banküberweisung',
            'Kreditkarte',
            'Bar',
            'Andere'
        ];

        foreach ($zahlungsarten as $art) {
            Zahlungsart::create(['name' => $art]);
        }
    }
}
