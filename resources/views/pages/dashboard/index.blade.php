@extends('layouts.dashboard')
@section('title', 'Dashboard')

@php
    $role = auth()->user()->role->name;
@endphp

@section('content')
    <div class="space-y-4">
        @if ($role === 'admin')
            @include('pages.dashboard.admin')
        @elseif ($role === 'employee')
            @include('pages.dashboard.employee')
        @endif
    </div>
@endsection
