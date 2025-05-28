<?php

namespace App\Http\Controllers;

use App\Models\Civ;
use App\Http\Requests\StoreCivRequest;
use App\Http\Requests\UpdateCivRequest;

class CivController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize("Menu paramètre BaseCDT");
        return view('back.civs.index');
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCivRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Civ $civ)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Civ $civ)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCivRequest $request, Civ $civ)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Civ $civ)
    {
        //
    }
}
