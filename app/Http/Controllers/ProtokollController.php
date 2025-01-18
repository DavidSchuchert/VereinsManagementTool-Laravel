<?php
namespace App\Http\Controllers;

use App\Models\Protokoll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ProtokollController extends Controller
{
    public function index()
    {
        $protokolle = Protokoll::latest()->paginate(10);
        return view('protokolle.index', compact('protokolle'));
    }

    public function create()
    {
        return view('protokolle.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Protokoll::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('protokolle.index')->with('success', 'Protokoll erstellt!');
    }

    public function edit(Protokoll $protokoll)
    {
        return view('protokolle.edit', compact('protokoll'));
    }

    public function update(Request $request, Protokoll $protokoll)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $protokoll->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('protokolle.index')->with('success', 'Protokoll aktualisiert!');
    }

    public function destroy(Protokoll $protokoll)
    {
        $protokoll->delete();
        return redirect()->route('protokolle.index')->with('success', 'Protokoll gelöscht!');
    }

    public function exportSinglePdf(Protokoll $protokoll)
    {
        $pdf = Pdf::loadView('pdf.protokoll', compact('protokoll'))->setPaper('a4', 'portrait');

        return $pdf->download('protokoll_' . $protokoll->id . '_' . date('Y-m-d_H-i-s') . '.pdf');
    }


}
