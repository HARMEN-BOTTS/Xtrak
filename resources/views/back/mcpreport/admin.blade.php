@extends('layouts.app',['title' => "Espace admin"])

@section('content')
@livewire('back.mcpreport.admin', ['mcpCode' => $mcpCode])
@endsection