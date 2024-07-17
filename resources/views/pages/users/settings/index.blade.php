@extends('layouts.app')

@section('title', __('My Settings'))

@section('content')
<x-container>
    <div class="w-full h-auto relative flex justify-start flex-col lg:flex-row items-start gap-6">
        <div
            class="flex flex-col gap-2 h-auto w-full lg:w-1/4 bg-white dark:bg-customBlack-dark border-b-2 border-gray-300 dark:border-customBlack-light rounded-lg p-2"
        >
        @forelse ($navigations as $navigation)
            <a href="{{ route("users.settings.index", $navigation['type']) }}" @class([
                "rounded font-semibold p-3 text-sm text-slate-800 dark:text-white",
                "border-b-2 bg-slate-100 border-customBlue dark:bg-customBlack-light !text-customBlue dark:border-customCyan dark:!text-customCyan" => $page == $navigation['type'],
                "dark:hover:bg-customBlack-light hover:bg-slate-100 hover:!text-customBlue dark:hover:!text-customCyan" => $page != $navigation['type']
            ])>
                <i class="{{ $navigation['icon'] }} mr-1"></i>
                {{ $navigation['title'] }}
            </a>
        @empty
            <div class="text-slate-800 dark:text-white text-sm font-semibold p-3">
                {{ __('No navigation found.') }}
            </div>
        @endforelse
        </div>
        <div class="h-auto w-full flex flex-col lg:w-3/4">
            @includeWhen($page, "pages.users.settings.fragments.{$page}")
        </div>
</x-container>
@endsection
