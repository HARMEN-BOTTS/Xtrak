<?php

namespace App\Http\Controllers;

use App\Models\nextStep;
use App\Http\Requests\StorenextStepRequest;
use App\Http\Requests\UpdatenextStepRequest;

class NextStepController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize("Menu paramètre BaseCDT");
        return view('back.nextstep.index');
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
    public function store(StorenextStepRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(nextStep $nextStep)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(nextStep $nextStep)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatenextStepRequest $request, nextStep $nextStep)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(nextStep $nextStep)
    {
        //
    }
}
