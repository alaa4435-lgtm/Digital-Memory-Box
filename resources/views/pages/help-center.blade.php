@extends('layouts.legal')

@section('title', __('auth.help_center'))

@section('content')
<div class="container mx-auto py-12">
    <h1 class="text-3xl font-bold mb-6">{{ __('help.title_help') }}</h1>

    <div class="space-y-6">
        <div>
            <h2 class="text-xl font-semibold">{{ __('help.what_is_title') }}</h2>
            <p>
                {{ __('help.what_is_description') }}
            </p>
        </div>

        <div>
            <h2 class="text-xl font-semibold">{{ __('help.create_box_title') }}</h2>
            <p>
                {{ __('help.create_box_description') }}
            </p>
        </div>

        <div>
            <h2 class="text-xl font-semibold">{{ __('help.need_help_title') }}</h2>
            <p>
                {{ __('help.need_help_description') }}
            </p>
        </div>
    </div>
</div>
@endsection