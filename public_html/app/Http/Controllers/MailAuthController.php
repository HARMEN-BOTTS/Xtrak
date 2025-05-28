<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MailAuth;

class MailAuthController extends Controller
{
    public function index()
    {
        // return view('livewire.back.mailauth.create');
        return view('back.mailauth.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'email' => 'required|email|unique:mail_auth,email',
            'passcode' => 'required|string|min:6',
        ]);

        MailAuth::create($validated);

        return redirect('/mail-auth')->with('success', 'Record added successfully.');
    }
}
