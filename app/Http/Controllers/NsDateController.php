<?php

namespace App\Http\Controllers;

use App\Models\NsDate;
use App\Http\Requests\StoreNsDateRequest;
use App\Http\Requests\UpdateNsDateRequest;

class NsDateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize("Menu paramètre BaseCDT");
        return view('back.nsdate.index');
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
    public function store(StoreNsDateRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(NsDate $nsDate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NsDate $nsDate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNsDateRequest $request, NsDate $nsDate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NsDate $nsDate)
    {
        //
    }
}
