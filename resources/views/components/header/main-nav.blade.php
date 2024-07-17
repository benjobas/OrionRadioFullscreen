@php($navigations = \App\Models\Navigation::getNavigations())

<div
    class="bg-customGreen-dark fixed top-0 dark:bg-customBlack-dark w-full z-50 lg:relative h-auto lg:h-16 dark:border-customBlack-dark lg:shadow-[0_20px_0_0_rgba(0,0,0,0.2)]"
    x-data="navigation"
    data-turbolinks-permanent
>
    <x-container class="h-full flex flex-col items-center justify-center lg:bg-customGreen-dark bg-customGreen-dark dark:bg-customBlack-dark">
        <div
            :class="{ 'border-b dark:border-gray-800': showMobileMenu }"
            class="flex lg:hidden p-4 w-full text-white justify-center items-center cursor-pointer"
            @click="showMobileMenu = !showMobileMenu"
        >
            <i class="fa-solid fa-bars" x-show="!showMobileMenu"></i>
            <i class="fa-solid fa-xmark" style="display: none" x-show="showMobileMenu"></i>
        </div>
        <nav class="h-full w-full lg:w-1/2" @click.away="showSubmenuId = null">
            <ul :class="{ 'hidden': !showMobileMenu, 'flex': showMobileMenu }"
                class="hidden lg:flex flex-col lg:flex-row divide-y relative dark:divide-customBlack-dark justify-center text-white dark:text-white font-medium text-sm items-center h-full"
            >
                @foreach ($navigations as $navigation)
                    <li @click="toggleMenu({{ $navigation->id }})" @class([
                        "relative group px-8 uppercase w-full lg:w-auto h-12 lg:h-full cursor-pointer",
                        "text-customBlue dark:text-customCyan font-semibold border-b-2 border-customBlue-light dark:border-customCyan-light" => \Route::current()->uri == ($navigation->slug == '/' ? $navigation->slug : ltrim($navigation->slug, '/'))
                    ])>
                        <a
                            class="w-full h-full flex justify-center items-center gap-1"
                            @if ($navigation->subNavigations->isEmpty()) href="{{ $navigation->slug }}" @endif
                        >
                            <div class="bg-center bg-no-repeat w-[25px] h-[25px]" style="background-image: url('{{ asset($navigation->icon) }}')"></div>
                            <span class="group-hover:text-customBlue-light dark:group-hover:text-customCyan-light transition-colors">{{ $navigation->label }}</span>
                            @unless ($navigation->subNavigations->isEmpty())
                                <span class="ml-2"><i class="fa-solid fa-chevron-down text-xs dark:text-slate-500"></i></span>
                            @endunless

                            @unless ($navigation->subNavigations->isEmpty())
                                <div class="absolute left-0 top-full min-w-full w-auto dark:bg-customCyan bg-white shadow-lg border-b-2 border-gray-200 dark:border-customCyan-dark rounded-b-md z-[1]"
                                    x-transition.origin.top.center
                                    x-show="showSubmenuId == {{ $navigation->id }}"
                                    style="display: none"
                                >
                                    <ul class="flex divide-y dark:divide-customBlack-dark flex-col">
                                        @foreach ($navigation->subNavigations as $subItem)
                                            <a @class([
                                                    "flex items-center bg-customGreen dark:bg-customBlack gap-1 px-4 py-3 hover:text-customBlue-light dark:hover:text-customCyan-light w-full",
                                                    "!text-customBlue-light dark:!text-customCyan-light" => strtolower(\Route::current()->uri) == ltrim($subItem->slug, '/')
                                                ])
                                                @if($subItem->new_tab) target="_blank" @endif
                                                href="{{ $subItem->slug }}"
                                            >
                                                <span>{{ $subItem->label }}</span>
                                                @if($subItem->new_tab)
                                                    <i class="fa-solid fa-up-right-from-square text-blue-300 text-[0.7rem] ml-1" data-tippy data-tippy-content="<small>{{ __('Opened in a new tab') }}</small>" data-tippy-placement="bottom"></i>
                                                @endif
                                            </a>
                                        @endforeach
                                    </ul>
                                </div>
                            @endunless
                        </a>
                    </li>
                @endforeach

                <div class="flex relative justify-center w-full lg:w-auto group gap-2 px-8 uppercase h-12 lg:h-full items-center">
                    <x-ui.buttons.default
                        class="!py-0.5 !px-1 bg-customBlue border border-customBlue-dark dark:border-customCyan-dark text-white dark:text-white dark:bg-customCyan"
                        @click="$dispatch('selectLanguageModal', true)"
                        data-tippy
                        data-tippy-content="<small>{{ __('Select Language') }}</small>"
                        data-tippy-placement="bottom"
                    >
                        <i class="icon border-none language {{ strtolower(app()->getLocale()) }}"></i>
                    </x-ui.buttons.default>

                    <x-ui.buttons.default
                        class="bg-customBlue border border-customBlue-dark dark:border-customCyan-dark hover:bg-customBlue-light dark:bg-customCyan dark:hover:bg-customCyan-light text-white dark:text-white"
                        @click="toggleTheme"
                        data-tippy
                        data-tippy-content="<small>{{ __('Toggle theme') }}</small>"
                        data-tippy-placement="bottom"
                    >
                        <template x-if="theme == 'light'">
                            <i class="fa-solid fa-sun text-white"></i>
                        </template>
                        <template x-if="theme == 'dark'">
                            <i class="fa-solid fa-moon"></i>
                        </template>
                    </x-ui.buttons.default>
                </div>
            </ul>
        </nav>
    </x-container>
</div>
