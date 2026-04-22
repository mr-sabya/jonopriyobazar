@extends('backend.layouts.app')

@section('title', 'Edit Administrator')

@section('content')
<livewire:backend.admin.manage userId="{{ $user->id }}" />
@endsection
