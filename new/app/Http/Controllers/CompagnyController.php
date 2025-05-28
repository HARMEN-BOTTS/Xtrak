<?php

namespace App\Http\Controllers;

use App\Models\Compagny;
use App\Http\Requests\StoreCompagnyRequest;
use App\Http\Requests\UpdateCompagnyRequest;

class CompagnyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize("Menu paramètre BaseCDT");
        return view('back.compagnies.index');
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
    public function store(StoreCompagnyRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Compagny $compagny)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Compagny $compagny)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompagnyRequest $request, Compagny $compagny)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Compagny $compagny)
    {
        //
    }
}
