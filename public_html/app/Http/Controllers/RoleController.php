<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $this->authorize('Gestion des rôles');

        return view('back.roles.index');
    }
}
