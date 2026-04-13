<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mitglied;
use App\Models\Inventar;
use App\Models\Category;
use App\Models\Zahlung;
use App\Models\Protokoll;

use App\Models\Zahlungsart;

class FakeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create 50 Members (German Faker locale generates real german names)
        Mitglied::factory(50)->create();

        // 2. Create realistic Inventory Categories
        $invCategories = [
            Category::create(['name' => 'Sportgeräte', 'type' => 'inventar']),
            Category::create(['name' => 'Büro & Verwaltung', 'type' => 'inventar']),
            Category::create(['name' => 'Veranstaltungstechnik', 'type' => 'inventar']),
            Category::create(['name' => 'Vereinskleidung', 'type' => 'inventar'])
        ];

        // 3. Create realistic Inventory Items
        $inventoryItems = ['Trainingsleibchen (30 Stück)', 'Fußbälle (10er Netz)', 'Markierungshütchen', 'Beamer', 'Kaffeemaschine', 'Klapptische (5 Stück)', 'Lautsprecher-Anlage', 'Vereinstrikots Heim', 'Erste-Hilfe-Kasten'];
        foreach($inventoryItems as $item) {
            Inventar::factory()->create([
                'artikel' => $item,
                'bemerkung' => 'Standardinventar des Vereins.',
                'kategorie_id' => $invCategories[array_rand($invCategories)]->id
            ]);
        }



        // 5. Create realistic Protocols
        $protocolTitles = ['Beschlüsse Vorstandssitzung Januar', 'Protokoll Kassenprüfung', 'Zusammenfassung Sommerfest-Planung', 'Mitgliederversammlung Q1', 'Dokumentation Platzumbau'];
        foreach($protocolTitles as $prot) {
            Protokoll::factory()->create([
                'title' => $prot,
                'content' => '<p>Hier sind die wichtigsten Stichpunkte der Besprechung zusammengefasst.</p><ul><li>Budget genehmigt</li><li>Nächster Termin steht fest</li><li>Aufgaben verteilt</li></ul>'
            ]);
        }

        // 6. Ensure Zahlungsarten exist and create Payments
        if (Zahlungsart::count() == 0) {
            $z1 = Zahlungsart::create(['name' => 'Banküberweisung']);
            $z2 = Zahlungsart::create(['name' => 'Barzahlung']);
            $z3 = Zahlungsart::create(['name' => 'SEPA-Lastschrift']);
            $artIds = [$z1->id, $z2->id, $z3->id];
        } else {
            $artIds = Zahlungsart::pluck('id')->toArray();
        }
        
        $zwecke = ['Mitgliedsbeitrag 2026', 'Spende', 'Kauf Vereinstrikots', 'Getränkeverkauf Sommerfest', 'Miete Vereinsheim', 'Turniergebühr'];
        for ($i = 0; $i < 100; $i++) {
            Zahlung::factory()->create([
                'beschreibung' => $zwecke[array_rand($zwecke)],
                'zahlungsart_id' => $artIds[array_rand($artIds)]
            ]);
        }
    }
}
