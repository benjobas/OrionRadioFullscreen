@php($showCmsToggleButton = config('hotel.client.nitro.cms_toggle_button'))
@php($showOnlineCountButton = config('hotel.client.nitro.online_count_button'))
@php($ShowRadioButtons = config('hotel.client.nitro.show_radio_buttons'))
@php($ShowFullscreenButton = config('hotel.client.nitro.show_fullscreen_button'))

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ getSetting('hotel_name') }}</title>

    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}" />
    @vite(['resources/scss/app.scss'])
</head>
<body
    class="w-full h-full dark:bg-slate-950 overflow-x-hidden"
    x-data="client(
        '{{ $showOnlineCountButton ? route('api.hotel.online-count') : null }}'
    )"
>
    <main>
        <div class="fixed z-50 top-0 left-0 pl-2 pt-2 h-12 flex gap-2">
            @if ($showCmsToggleButton)
            <x-ui.buttons.default
                class="dark:bg-customBlue bg-customBlue border-customBlue-dark hover:bg-customBlue-light dark:hover:bg-customBlue-light dark:shadow-customBlue-700/75 shadow-customBlue-600/75 py-2 text-white"
                @click="toggleCms"
            >
                <template x-if="!showCmsFrame">
                    <i class="fa-solid fa-house-user"></i>
                </template>

                <template x-if="showCmsFrame">
                    <i class="fa-solid fa-rotate-left"></i>
                </template>
            </x-ui.buttons.default>
            @endif

            @if ($showOnlineCountButton)
            <div
                x-transition.duration.1000ms
                x-show="!showCmsFrame"
            >
                <x-ui.buttons.default
                    class="dark:bg-customGreen bg-customGreen border-customGreen-dark hover:bg-customGreen-light dark:hover:bg-customBlue dark:shadow-slate-700/75 shadow-slate-600/75 py-2 text-white"
                    @click="reloadOnlineCount()"
                >
                    <i class="fa-solid fa-users relative">
                        <i class="fa fa-solid fa-circle text-green-400 absolute right-0 bottom-0 fa-2xs"></i>
                    </i>
                    <span x-text="onlineCount"></span>
                </x-ui.buttons.default>
            </div>
            @endif

              <!-- Radio Button -->
               @if ($ShowRadioButtons)
              <div class="focus:outline-none disabled:!text-slate-300 disabled:cursor-not-allowed disabled:!bg-customGreen disabled:!border-customGreen-dark transition-colors p-2 px-4 text-sm relative gap-2 justify-center items-center font-semibold flex rounded border-b-4 dark:bg-customGreen bg-customGreen border-customGreen-dark hover:bg-customGreen dark:hover:bg-customGreen dark:shadow-slate-700/75 shadow-customGreen-600/75 py-2 text-white">
                <audio id="audioPlayer" autoplay></audio>
                <button id="togglePlayButton" class="radioButton bg-transparent hover:bg-customGreen-light text-white p-2">
                    <i id="playPauseIcon" class="fa-solid fa-play"></i>
                </button>
                <button id="volumeDownButton" class="radioButton bg-transparent hover:bg-customGreen-light text-white p-2">
                    <i class="fa-solid fa-volume-down"></i>
                </button>
                <button id="volumeUpButton" class="radioButton bg-transparent hover:bg-customGreen-light text-white p-2">
                    <i class="fa-solid fa-volume-up"></i>
                </button>
            </div>
            @endif

            <!-- Fullscreen Button -->
             @if ($ShowFullscreenButton)
            <button
                class="focus:outline-none disabled:!text-slate-300 disabled:cursor-not-allowed disabled:!bg-customGreen disabled:!border-customGreen-dark transition-colors p-2 px-4 text-sm relative gap-2 justify-center items-center font-semibold flex rounded border-b-4 dark:bg-slate-500 bg-customGreen border-customGreen-dark hover:bg-customGreen-light dark:hover:bg-customGreen-light dark:shadow-slate-700/75 shadow-slate-600/75 py-2 text-white" id="fullscreenButton"
            >
                <i class="fa-solid fa-arrows-alt"></i>
            </button>
            @endif
            <!-- End Radio and Fullscreen Buttons -->
        </div>

        <div
            x-transition.origin.top.center
            x-show="!showCmsFrame"
        >
            <iframe
                id="nitro-client"
                src="{{ $nitroClientUrl }}?sso={{ $authTicket }}"
                class="w-screen dark:bg-slate-950 h-screen overflow-hidden left-0 top-0 border-none m-0 p-0"
                allow="fullscreen"
            ></iframe>
        </div>

        @if ($showCmsToggleButton)
        <div
            x-show="showCmsFrame"
            style="display: none"
        >
            <iframe
                src="/?fromClient=1"
                class="overflow-hidden dark:bg-slate-950 left-0 top-0 w-screen h-screen border-none m-0 p-0 z-20"
                allow="fullscreen"
            >
            </iframe>
        </div>
        @endif

        <div class="fixed z-[150] bg-black/[0.9] top-0 left-0 w-full h-full flex justify-center items-center flex-col gap-4"
            x-transition
            x-show="isDisconnected"
            style="display: none"
        >
            <span class="text-4xl text-center text-white font-bold flex gap-2 animate__animated animate__pulse animate__infinite">
                {{ __('You have been disconnected.') }}
            </span>

            <div class="flex gap-4">
                <x-ui.buttons.redirectable
                    class="dark:bg-emerald-500 bg-emerald-500 border-emerald-700 hover:bg-emerald-400 dark:hover:bg-emerald-400 dark:shadow-emerald-700/75 shadow-emerald-600/75 py-2 text-white"
                    href="{{ route('hotel.nitro') }}"
                >
                    {{ __('Reload') }}
                </x-ui.buttons.redirectable>

                <x-ui.buttons.redirectable
                    class="dark:bg-orange-500 bg-orange-500 border-orange-700 hover:bg-orange-400 dark:hover:bg-orange-400 dark:shadow-orange-700/75 shadow-orange-600/75 py-2 text-white"
                    href="{{ route('index') }}"
                >
                    {{ __('Back to website') }}
                </x-ui.buttons.redirectable>
            </div>
        </div>
    </main>

    @vite(['resources/js/client.js'])
    <script src="{{ asset('assets/js/nitro-external.js') }}"></script>
    <script>window.streamUrl = @json(config('hotel.client.nitro.stream_url'));</script>
</body>
</html>
