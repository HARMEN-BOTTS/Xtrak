@extends('layouts.app', ['title' => 'Détails du candidat'])

@section('content')
    @livewire('back.candidates.show', ['candidate' => $candidate])
@endsection
