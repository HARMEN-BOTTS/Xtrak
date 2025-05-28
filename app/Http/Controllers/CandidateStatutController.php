<?php

namespace App\Http\Controllers;

use App\Models\candidateStatut;
use App\Http\Requests\StorecandidateStatutRequest;
use App\Http\Requests\UpdatecandidateStatutRequest;

class CandidateStatutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize("Menu paramètre BaseCDT");
        return view('back.statuts.index');
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
    public function store(StorecandidateStatutRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(candidateStatut $candidateStatut)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(candidateStatut $candidateStatut)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatecandidateStatutRequest $request, candidateStatut $candidateStatut)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(candidateStatut $candidateStatut)
    {
        //
    }
}
