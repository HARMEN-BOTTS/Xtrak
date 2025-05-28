@extends('layouts.app', ['title' => "Détail du C.R.E"])

@section('content')
    @livewire('back.cres.show', ['candidate'=>$candidate])
@endsection
    