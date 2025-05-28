@extends('layouts.app', ['title' => "Détail C.R.E"])

@section('content')
    @livewire('back.cres.show', ['candidate'=>$candidate])
@endsection
    