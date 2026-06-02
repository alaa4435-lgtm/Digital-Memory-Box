@extends('layouts.legal')

@section('title', __('auth.privacy'))

@section('content')
<div class="container mx-auto py-12">
    <h1 class="text-3xl font-bold mb-6">{{ __('privacy.title_privacy') }}</h1>

    <p>
        {{ __('privacy.introduction_privacy') }}
    </p>

    <h2 class="text-xl font-semibold mt-6 mb-2">
        {{ __('privacy.information_collect_title') }}
    </h2>

    <ul class="list-disc ml-6">
        <li>{{ __('privacy.information_collect_item_1') }}</li>
        <li>{{ __('privacy.information_collect_item_2') }}</li>
        <li>{{ __('privacy.information_collect_item_3') }}</li>
    </ul>

    <h2 class="text-xl font-semibold mt-6 mb-2">
        {{ __('privacy.information_use_title') }}
    </h2>

    <ul class="list-disc ml-6">
        <li>{{ __('privacy.information_use_item_1') }}</li>
        <li>{{ __('privacy.information_use_item_2') }}</li>
        <li>{{ __('privacy.information_use_item_3') }}</li>
    </ul>
</div>
@endsection