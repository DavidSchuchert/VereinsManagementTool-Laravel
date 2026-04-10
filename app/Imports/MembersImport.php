<?php

namespace App\Imports;

use App\Models\Mitglied;
use App\Models\Rangart;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MembersImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        // Find Rang by name
        $rang = Rangart::where('name', $row['rang'])->first();

        return new Mitglied([
            'mitgliedsnummer' => $row['mitgliedsnummer'],
            'vorname'         => $row['vorname'],
            'nachname'        => $row['nachname'],
            'email'           => $row['email'],
            'telefon'         => $row['telefon'] ?? null,
            'plz'             => $row['plz'],
            'ort'             => $row['ort'],
            'strasse'         => $row['strasse'],
            'hausnummer'      => $row['hausnummer'],
            'eintrittsdatum'  => $row['eintrittsdatum'],
            'rang_id'         => $rang ? $rang->id : 1, // Default to first rank if not found
        ]);
    }

    public function rules(): array
    {
        return [
            'mitgliedsnummer' => 'required|unique:mitglieder,mitgliedsnummer',
            'vorname'         => 'required|string',
            'nachname'        => 'required|string',
            'email'           => 'required|email',
            'plz'             => 'required',
            'ort'             => 'required',
            'eintrittsdatum'  => 'required',
        ];
    }
}
