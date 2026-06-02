@extends('layouts.legal')

@section('title', __('auth.terms'))

@section('content')
<div class="container mx-auto py-12">
    <h1 class="text-3xl font-bold mb-6">{{ __('terms.title_terms') }}</h1>

    <p class="mb-4">
        {{ __('terms.introduction_terms') }}
    </p>

    <h2 class="text-xl font-semibold mt-6 mb-2">
        {{ __('terms.user_responsibilities_title') }}
    </h2>

    <ul class="list-disc ml-6">
        <li>{{ __('terms.user_responsibility_1') }}</li>
        <li>{{ __('terms.user_responsibility_2') }}</li>
        <li>{{ __('terms.user_responsibility_3') }}</li>
    </ul>

    <h2 class="text-xl font-semibold mt-6 mb-2">
        {{ __('terms.account_termination_title') }}
    </h2>

    <p>
        {{ __('terms.account_termination_text') }}
    </p>
</div>
@endsection