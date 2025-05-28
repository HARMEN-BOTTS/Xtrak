@extends('layouts.app', ['title' => $state.'s'])

@section('content')
    @livewire('back.candidates.state',['state'=>$state])
@endsection
