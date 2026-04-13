<?php
namespace App\Http\Controllers;

use App\Models\Protokoll;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ProtokollController extends Controller
{
    public function index()
    {
        return view('protokolle.index');
    }

    public function exportSinglePdf(Protokoll $protokoll)
    {
        $pdf = Pdf::loadView('pdf.protokoll', compact('protokoll'))->setPaper('a4', 'portrait');

        return $pdf->download('protokoll_' . $protokoll->id . '_' . date('Y-m-d_H-i-s') . '.pdf');
    }
}
