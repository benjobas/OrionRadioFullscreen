@php($isCommonRoute = in_array(Route::current()->getName(), ['register', 'index', 'login']))
@php($registerButtonAction = $isCommonRoute ? "Turbolinks.visit('/register')" : 'showRegisterModal = true')

<div class="w-full">
    <div class="w-full mx-auto gap-24 flex flex-col lg:flex-row h-auto p-1 justify-between items-start">
        <div class="w-full flex flex-col gap-2 lg:w-1/3">
            <!-- Authentication Form -->
            <nav class="w-full lg:mt-20 relative flex justify-center items-center">
                <div class="flex relative h-full justify-center items-center px-1 lg:px-2 rounded-t-lg" x-data="authentication">
                <div @openLoginModal.window="showLoginModal = true" @openRegisterModal.window="showRegisterModal = true" x-init="$nextTick(() => { if ({{ $isCommonRoute }}) { showLoginModal = true; } })">
                        <!-- Contenido del formulario de inicio de sesión -->
                        <div class="flex items-center justify-center w-full" x-show="showLoginModal">
                            <x-forms.login />
                        </div>
                </div>
            </nav>
        </div>
        <div class="w-full mx-auto gap-8 flex flex-col lg:flex-row h-auto justify-between items-start">
            <div class="w-full flex flex-col gap-4">
                <x-title-box title="{{ __('Latest Articles') }}" description="{{ __('Check out the latest articles below') }}" icon="articles">
                    <x-ui.buttons.redirectable href="{{ route('articles.index') }}" class="dark:bg-customCyan bg-customBlue border-customBlue-dark dark:border-customCyan-dark hover:bg-customBlue-light dark:hover:bg-customCyan-light dark:shadow-customCyan-700/75 shadow-customBlue-600/75 py-2 text-white">
                        {{ __('View All') }}
                    </x-ui.buttons.redirectable>
                </x-title-box>
                <!-- Aquí va la cuadrícula de artículos -->
                <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-3">
                @foreach ($defaultArticles as $defaultArticle)
                    <div class="w-full bg-white dark:bg-customBlack-dark rounded-lg border-b-2 border-gray-300 dark:border-customBlack-dark shadow-lg">
                        <div class="w-full h-full flex flex-col gap-2 p-1">
                            <div
                                class="w-full h-48 flex relative justify-start items-start bg-center bg-no-repeat rounded-md"
                                style="background-image: url('{{ $defaultArticle->image }}')"
                            >
                            @if ($defaultArticle->fixed)
                                <i data-tippy data-tippy-content="{{ __('Fixed') }}" class="icon small w-[13px] h-[15px] border-none shadow-none rounded-none ifixed float-left"></i>
                            @endif
                            </div>
                            <div class="flex w-full flex-col">
                                <span class="w-full flex gap-2 justify-start items-center text-slate-700 max-h-[45px] overflow-hidden dark:text-slate-400 text-xs">
                                    <div
                                        @class([
                                            "w-[30px] h-[30px] bg-no-repeat rounded-full bg-gray-200 dark:bg-customBlack-dark",
                                            "bg-center" => !$usingNitroImager,
                                            "bg-[-7px_-10px]" => $usingNitroImager
                                        ])
                                        style="background-image: url('{{ getFigureUrl($defaultArticle->user->look, 'head_direction=2&size=s&headonly=1') }}')"
                                    ></div>
                                    <a class="underline underline-offset-2 hover:text-customBlue-light" href="{{ route('users.profile.show', $defaultArticle->user->username) }}">{{ $defaultArticle->user->username }}</a>
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="w-full mx-auto gap-8 mt-8 flex flex-col lg:flex-row h-auto justify-between items-start">
        <div class="w-full flex flex-col gap-2 lg:w-1/3">
            <x-title-box
                title="{{ __('Latest Users') }}"
                description="{{ __('The most recent users') }}"
                icon="users"
            />
            <div class="w-full grid grid-cols-4 grid-rows-4 flex-wrap gap-3">
                @foreach ($latestUsers as $latestUser)
                    <div
                        onclick="Turbolinks.visit('{{ route('users.profile.show', $latestUser->username) }}')"
                        data-tippy-singleton
                        data-tippy-content="<small>{{ $latestUser->username }}</small>"
                        @class([
                            "h-16 bg-white rounded-lg shadow-lg border-b-2 border-gray-300 dark:border-customBlack-dark dark:bg-customBlack-dark bg-no-repeat cursor-pointer",
                            "bg-center" => !$usingNitroImager,
                            "bg-[-5px_-20px]" => $usingNitroImager
                        ])
                        style="background-image: url('{{ getFigureUrl($latestUser->look, 'head_direction=3&size=m&gesture=sml&action=sit,wav&headonly=1') }}')"
                    ></div>
                @endforeach
            </div>
        </div>

        <div class="w-full lg:w-2/3">
            <div class="w-full flex flex-col gap-2">
                <x-title-box
                    title="{{ __('Latest User Photos') }}"
                    description="{{ __('Stay on top of what users are doing at the hotel') }}"
                    icon="camera"
                >
                    <x-ui.buttons.redirectable
                        href="{{ route('community.photos.index') }}"
                        class="dark:bg-customCyan bg-customBlue border-customBlue-dark dark:border-customCyan-dark hover:bg-customBlue-light dark:hover:bg-customCyan-light dark:shadow-customCyan-700/75 shadow-customBlue-600/75 py-2 text-white"
                    >
                        {{ __('View All') }}
                    </x-ui.buttons.redirectable>
                </x-title-box>
                <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 grid-rows-2 gap-2">
                    @foreach ($photos as $photo)
                        <div class="w-full bg-white dark:bg-customBlack-dark rounded-lg border-b-2 border-gray-300 dark:border-customBlack-dark shadow-lg hover:scale-[1.05] transition-transform">
                            <div class="w-full h-35 relative flex flex-col p-1">
                                <a href="{{ route('community.photos.index') }}" class="w-full h-full flex justify-center items-center bg-center bg-no-repeat rounded-md" style="background-image: url('{{ $photo->url }}')"></a>
                                <span class="w-auto absolute bottom-2 left-2 flex gap-2 justify-start items-center text-slate-700 max-h-[45px] overflow-hidden dark:text-slate-400 text-xs">
                                    @if($photo->user)
                                        <div
                                            @class([
                                                "w-auto pr-3 max-w-[100px] h-[30px] bg-start pl-8 flex items-center bg-no-repeat rounded-full bg-gray-200 dark:bg-slate-900",
                                                "bg-[-8px_-10px]" => $usingNitroImager
                                            ])
                                            style="background-image: url('{{ getFigureUrl($photo->user?->look, 'direction=4&head_direction=2&size=s&gesture=sml&action=sit,wav&headonly=1') }}')"
                                        >
                                            <a class="underline underline-offset-2 hover:text-customBlue-light" href="{{ route('users.profile.show', $photo->user->username) }}">{{ $photo->user->username }}</a>
                                        </div>
                                    @endif
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>