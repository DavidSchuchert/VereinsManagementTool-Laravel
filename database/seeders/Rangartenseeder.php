<?php

namespace Database\Seeders;

use App\Models\Rangart;
use Illuminate\Database\Seeder;

class Rangartenseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rangarten = [
            'Gründungsmitglied',
            'Supportmitglied',
            'Ordentlichesmitglied',
            'Sonstiges'
        ];

        foreach ($rangarten as $art) {
            Rangart::create(['name' => $art]);
        }
    }
}
