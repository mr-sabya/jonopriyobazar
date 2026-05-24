@extends('layouts.back')

@section('title', 'Package Request')

@section('content')

<livewire:backend.wallet.application.show id="{{ $user->id }}" />
@endsection