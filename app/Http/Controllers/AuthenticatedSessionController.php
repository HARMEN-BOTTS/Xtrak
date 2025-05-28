<?php

namespace App\Http\Controllers;

use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController as FortifyAuthenticatedSessionController;
use Illuminate\Http\Request;
use App\Models\UserLogin; // Assurez-vous d'importer le modèle UserLogin si vous l'utilisez

class AuthenticatedSessionController extends FortifyAuthenticatedSessionController
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (auth()->attempt($request->only('email', 'password'))) {
            $user = auth()->user();
            UserLogin::create([
                'user_id' => $user->id,
                'login_at' => now(),
            ]);
            $user->update([
                'last_seen' => now(),
                'is_connect' => true,
            ]);
            return redirect()->route('home');
        }

        return back()->with('error', 'Identifiants incorrects');
    }
    public function logOut(Request $request)
    {
        $user = auth()->user();
        $lastLogin = UserLogin::where('user_id', $user->id)
            ->orderBy('login_at', 'desc')
            ->first();

        if ($lastLogin) {
            $lastLogin->update([
                'logout_at' => now(),
            ]);
        }
        $user->update([
            'is_connect' => false,
            'last_seen' => now(),
        ]);
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
