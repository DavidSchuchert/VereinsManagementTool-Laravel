<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    /**
     * Zeige das Formular zum Erstellen eines Benutzers.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Speichere einen neuen Benutzer in der Datenbank.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return Redirect::route('users.create')->with('status', 'Benutzer erfolgreich erstellt.');
    }

    public function index()
    {
        $users = User::all();

        return view('users.index', compact('users'));
    }

    public function destroy(User $user)
    {
        // Überprüfen, dass der Benutzer nicht der Benutzer mit der ID 1 ist
        if ($user->id === 1) {
            return redirect()->route('users.index')->withErrors('Dieser Benutzer kann nicht gelöscht werden.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('status', 'Benutzer erfolgreich gelöscht.');
    }

}
