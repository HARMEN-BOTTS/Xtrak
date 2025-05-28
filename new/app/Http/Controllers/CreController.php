<?php

namespace App\Http\Controllers;

use App\Models\Cre;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\StoreCreRequest;
use App\Http\Requests\UpdateCreRequest;

class CreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }
    public function form($candidate, $action)
    {
       
        return view('back.cres.form', [
            'action' => $action,
            'cre' => new Cre(),
            'candidate' => $candidate,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCreRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function candidateCre(Candidate $candidate)
    {
        return view('back.cres.show', [
            'candidate' => $candidate,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cre $cre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCreRequest $request, Cre $cre)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cre $cre)
    {
        //
    }

}
