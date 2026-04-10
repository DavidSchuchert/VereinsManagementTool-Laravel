<?php

namespace App\Exports;

use App\Models\Protokoll;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProtokollExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Protokoll::with('user')->get();
    }

    public function headings(): array
    {
        return [
            'Datum',
            'Titel',
            'Erstellt von',
            'Inhalt',
        ];
    }

    public function map($protocol): array
    {
        return [
            $protocol->created_at->format('d.m.Y'),
            $protocol->title,
            $protocol->user->name ?? 'System',
            strip_tags($protocol->content),
        ];
    }
}
