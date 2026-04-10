<?php

namespace App\Exports;

use App\Models\Mitglied;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MembersExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Mitglied::with('rangart')->get();
    }

    public function headings(): array
    {
        return [
            'Mitgliedsnummer',
            'Vorname',
            'Nachname',
            'E-Mail',
            'Telefon',
            'PLZ',
            'Ort',
            'Straße',
            'Hausnummer',
            'Eintrittsdatum',
            'Austrittsdatum',
            'Rang',
        ];
    }

    public function map($member): array
    {
        return [
            $member->mitgliedsnummer,
            $member->vorname,
            $member->nachname,
            $member->email,
            $member->telefon,
            $member->plz,
            $member->ort,
            $member->strasse,
            $member->hausnummer,
            $member->eintrittsdatum,
            $member->austrittsdatum,
            $member->rangart->name ?? 'Kein Rang',
        ];
    }
}
