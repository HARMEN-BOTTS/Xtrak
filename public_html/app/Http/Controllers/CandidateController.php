<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Http\Requests\StoreCandidateRequest;
use App\Http\Requests\UpdateCandidateRequest;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('Menu accès BaseCDT');
        return view('back.candidates.index');
    }

    public function state($state)
    {
        $this->authorize('Menu etats');
        return view('back.candidates.state', ['state' => $state]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('Menu saisie');
        return view('back.candidates.form', [
            'action' => 'create',
            'candidate' => new Candidate(),
        ]);
    }
    public function edit(Candidate $candidate)
    {
        
        return view('back.candidates.form', [
            'action' => 'update',
            'candidate' => $candidate,
        ]);
    }
    public function show(Candidate $candidate)
    {
        // $this->authorize('Voir un candidat');
        return view('back.candidates.show', [
            'candidate' => $candidate,
        ]);
    }

    public function import()
    {
        $this->authorize('Importer des candidats');
        return view('back.candidates.import');
    }
    public function candidateCv(Candidate $candidate)
    {
        return view('back.candidates.cv', [
            'candidate' => $candidate,
        ]);
    }
    public function showFile(Candidate $candidate)
{
    $files = File::all();
    return view('livewire.back.files.candidate-file', ['candidate' => $candidate]);}

}
