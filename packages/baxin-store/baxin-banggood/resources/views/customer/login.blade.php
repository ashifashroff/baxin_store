@extends('baxin-banggood::layouts.master')
@section('title', 'Sign In — Baxin Store')

@section('content')

<div class="max-w-md mx-auto px-4 py-16">
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Welcome Back</h1>
        <p class="text-sm text-gray-500 mt-2">Sign in to your Baxin Store account</p>
    </div>

    <div id="app">
        <bagisto-login></bagisto-login>
    </div>
</div>

@endsection
