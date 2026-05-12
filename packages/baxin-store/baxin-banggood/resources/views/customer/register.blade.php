@extends('baxin-banggood::layouts.master')
@section('title', 'Create Account — Baxin Store')

@section('content')

<div class="max-w-md mx-auto px-4 py-16">
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Create Account</h1>
        <p class="text-sm text-gray-500 mt-2">Join Baxin Store for exclusive deals</p>
    </div>

    <div id="app">
        <bagisto-register></bagisto-register>
    </div>
</div>

@endsection
