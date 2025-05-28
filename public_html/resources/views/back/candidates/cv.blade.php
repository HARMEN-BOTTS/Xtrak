@extends('layouts.app', ['title' => "Curriculum Vitae du candidat"])

@section('content')
    @livewire('back.candidates.cv', ['candidate'=>$candidate])
@endsection
    