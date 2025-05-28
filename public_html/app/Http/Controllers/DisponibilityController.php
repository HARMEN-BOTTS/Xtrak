<?php

namespace App\Http\Controllers;

use App\Models\Disponibility;
use App\Http\Requests\StoreDisponibilityRequest;
use App\Http\Requests\UpdateDisponibilityRequest;

class DisponibilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize("Menu paramètre BaseCDT");
        return view('back.disponibilities.index');
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
    public function store(StoreDisponibilityRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Disponibility $disponibility)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Disponibility $disponibility)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDisponibilityRequest $request, Disponibility $disponibility)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Disponibility $disponibility)
    {
        //
    }
}
