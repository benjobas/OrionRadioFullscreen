<div class="w-full mt-12 p-2 shadow dark:border-customBlack-dark bg-customGreen-dark dark:bg-customBlack-dark" x-data="footer">
    <x-ui.buttons.default
        class="bottom-3 right-3 z-10 bg-customBlue border-customBlue-dark hover:bg-customBlue-light text-white dark:bg-customCyan dark:border-customCyan-dark dark:hover:bg-customCyan-light"
        x-bind:class="{ '!hidden': !showScrollButton, '!fixed': showScrollButton }"
        @click="scrollToTop"
    >
        <i class="fa-solid fa-chevron-up"></i>
    </x-ui.buttons.default>

    <x-container class="flex justify-center gap-1 items-center text-sm flex-col">
        <span class="dark:text-gray-200 text-white">
            {!! __('© OrionCMS - Developed by :orion', [
                    'orion' => <<<HTML
                        <a
                            target="_blank"
                            href="https://github.com/orion-server"
                            class="underline underline-offset-4 text-blue-400"
                        >
                            Orion Server
                        </a>
                    HTML
                ])
            !!}</span>
        <span class="font-semibold text-white dark:text-white">{{ __('This website is a not-for-profit educational project.') }}</span>
    </x-container>
</div>

@include('components.select-language-modal')
