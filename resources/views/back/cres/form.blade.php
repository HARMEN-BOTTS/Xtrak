@extends('layouts.app', ['title' => "Ajout d'un nouveau C.R.E"])

@section('content')
    @livewire('back.cres.form', ['action' => $action,'cre'=>$cre,'candidate'=>$candidate])
@endsection
    