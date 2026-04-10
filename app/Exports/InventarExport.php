<?php

namespace App\Exports;

use App\Models\Inventar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class InventarExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Inventar::with('category')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Artikel',
            'EAN',
            'Menge',
            'Lagerstandort',
            'Kategorie',
            'Bemerkung',
        ];
    }

    public function map($item): array
    {
        return [
            $item->id,
            $item->artikel,
            $item->ean,
            $item->menge,
            $item->lagerstandort,
            $item->category->name ?? 'Keine Kategorie',
            $item->bemerkung,
        ];
    }
}
