@php($cleanLayout = true)

@extends('layouts.app')

@section('title', __('Two-Factor Challenge'))

@section('content')
<x-container class="flex flex-col gap-4 justify-center items-center h-screen">
    <div class="fixed top-0 left-0 w-screen h-screen bg-black/25"></div>
    <div style="--logo-width: {{ $logoSize[0] }}px; --logo-height: {{ $logoSize[1] }}px; background-image: url({{ $logo }})" class="logo bg-center bg-no-repeat"></div>
    <div class="bg-white w-full lg:w-1/2 dark:bg-customBlack-dark overflow-hidden rounded-lg shadow relative border border-slate-300 dark:border-customBlack-light p-4">
        <form class="flex flex-col gap-4" method="POST" action="{{ route('two-factor.login') }}">
            @csrf

            <div class="flex flex-col">
                <x-ui.input
                    label="{{ __('Two-Factor Code') }}"
                    id="two-factor-code"
                    icon="fa-solid fa-key"
                    name="code"
                    :autofocus="true"
                    max="6"
                    min="6"
                    placeholder="{{ __('Code') }}"
                    type="number"
                />
            </div>

            <div class="flex flex-col">
                <x-ui.buttons.default
                    type="submit"
                    class="dark:bg-customCyan dark:border-customCyan-dark bg-customBlue border-customBlue-dark hover:bg-customBlue-light dark:hover:bg-customCyan-light dark:shadow-customCyan-700/75 shadow-customBlue-600/75 flex-1 py-3 text-white">
                    <i class="fa-regular fa-square-check"></i>
                    {{ __('Submit') }}
                </x-ui.buttons.default>
            </div>
        </form>
    </div>
</x-container>
@endsection

@if($errors->has('code'))
    <script>
        document.addEventListener('alpine:init', () => {
            window.notyf.error("{{ $errors->first('code') }}", 8000)
        });
    </script>
@endif
