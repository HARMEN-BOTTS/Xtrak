@extends('layouts.app', ['title' => "Ajout d'un nouveau candidat"])

@section('content')
    @livewire('back.candidates.form', ['action' => $action,'candidate'=>$candidate])
@endsection
    