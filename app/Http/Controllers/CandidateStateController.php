<?php

namespace App\Http\Controllers;

use App\Models\candidateState;
use App\Http\Requests\StorecandidateStateRequest;
use App\Http\Requests\UpdatecandidateStateRequest;

class CandidateStateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize("Menu paramètre BaseCDT");
        return view('back.states.index');
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
    public function store(StorecandidateStateRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(candidateState $candidateState)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(candidateState $candidateState)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatecandidateStateRequest $request, candidateState $candidateState)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(candidateState $candidateState)
    {
        //
    }
}
