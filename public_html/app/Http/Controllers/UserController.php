<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('Gestion des permissions');

        return view('back.users.index');
    }
    public function profile()
    {
        $this->authorize('Menu paramètres');
        return view('back.users.profile');
    }
    
}
