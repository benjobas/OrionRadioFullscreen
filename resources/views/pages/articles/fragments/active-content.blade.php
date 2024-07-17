@props([
    'activeArticle' => null
])

<div
    class="w-full !bg-cover !bg-no-repeat !bg-center h-32 flex rounded-lg shadow-lg justify-between border-b-2 border-gray-300 dark:border-customBlack-light"
    style="background: linear-gradient(to right, {{ $activeArticle->predominant_color }}, transparent), url('{{ $activeArticle->image }}')"
>
    <span class="w-full h-full font-semibold flex justify-start py-2 px-4" style="color: {{ $activeArticle->titleColor }}">
        {{ $activeArticle->title }}
    </span>
</div>
<div>
    <div class="active-article-content text-sm prose dark:prose-invert !max-w-full ck-content w-full dark:text-slate-200 mt-4 h-auto p-4 bg-white dark:bg-customBlack-dark rounded-t-lg shadow-lg">
        {!! $activeArticle->content !!}
    </div>
    <div class="w-full flex border-t dark:border-customBlack-dark flex-col lg:flex-row gap-4 lg:gap-0 h-auto lg:h-20 lg:divide-x dark:divide-customBlack-dark py-2 overflow-hidden px-4 bg-gray-100 dark:bg-customBlack rounded-b-lg shadow-lg">
        <div class="w-full overflow-hidden lg:w-1/3 h-20 border-b dark:border-customBlack-dark lg:border-none lg:h-full relative flex justify-center flex-col items-center gap-1 pl-24">
            <div @class([
                "rounded-lg w-22 h-22 absolute border-4 shadow-inner bg-cover bg-center bg-no-repeat -bottom-8 lg:-bottom-10 left-0",
                "border-blue-300 shadow-blue-500" => $activeArticle->user->isMale(),
                "border-pink-300 shadow-pink-500" => $activeArticle->user->isFemale()
            ]) style="background-image: url('{{ $activeArticle->user->getAvatarBackground() }}')">
                <div
                    @class([
                        "w-[64px] h-[110px] absolute",
                        "bottom-2 left-2" => !$usingNitroImager,
                        "bottom-4 left-0" => $usingNitroImager
                    ])
                    style="background-image: url('{{ getFigureUrl($activeArticle->user->look, 'direction=2&head_direction=2&size=m&gesture=sml') }}')"
                ></div>
            </div>
            <a
                href="{{ route('users.profile.show', $activeArticle->user->username) }}"
                class="truncate w-full font-semibold underline underline-offset-2 text-customBlue dark:text-customCyan"
            >
                {{ $activeArticle->user->username }}
            </a>
            <span class="text-xs w-full dark:text-slate-200"><b class="text-zinc-600 dark:text-slate-200">{{ __('Date') }}:</b> {{ $activeArticle->created_at->format('Y-m-d H:i') }}</span>
        </div>
        <div class="w-full lg:w-2/3 h-full flex-col lg:flex-row relative divide-y dark:divide-customBlack-dark pl-2">
            @auth
            <div
                class="w-full h-10 lg:h-1/2 flex items-center"
                x-data="articleNotification('{{ route('articles.author-notifications.toggle', [$activeArticle->id, $activeArticle->slug]) }}', {{ $activeArticle->user->followers->contains('user_id', \Auth::id()) ? 'true' : 'false' }})"
            >
                <x-ui.toggle
                    alpine-model="isSubscriber"
                    disabled="delay"
                    label="{{ __('Always get notifications from this author') }}"
                />
            </div>
            @endauth
            <div class="w-full h-10 lg:h-1/2 py-1 flex gap-1 items-center justify-start flex-wrap">
                @forelse ($activeArticle->tags as $tag)
                    <span @class([
                        "text-xs font-medium rounded-lg px-2",
                        "text-slate-800" => !isDarkColor($tag->background_color),
                        "text-white" => isDarkColor($tag->background_color)
                    ]) style="background-color: {{ $tag->background_color }}">{{ $tag->name }}</span>
                @empty
                    <span class="text-xs text-gray-900 dark:text-gray-400">
                        {{ __('No tags found.') }}
                    </span>
                @endforelse
            </div>
        </div>
    </div>
    @include('pages.articles.fragments.article-reactions')
</div>
@if ($activeArticle->allow_comments)
<div class="mt-8 w-full h-auto">
    @auth
        <div class="mb-8">
            <x-title-box
                title="{{ __('Comment this Article') }}"
                description="{{ __('Write your opinion below') }}"
                icon="comment"
            />
            <div class="bg-white w-full h-auto dark:bg-customBlack-dark p-1 rounded-lg border-b-2 border-gray-300 dark:border-slate-800 shadow-lg mt-8">
                <x-ui.textarea
                    route="{{ route('articles.comments.store', [$activeArticle->id, $activeArticle->slug]) }}"
                    id="comment"
                    placeholder="{{ __('Write a comment...') }}"
                >
                    <x-slot:actions>
                        <x-ui.buttons.loadable
                            alpine-model="previewLoading"
                            @click="onPreviewRequest"
                            type="button"
                            class="dark:bg-customCyan dark:border-customCyan-dark bg-customBlue border-customBlue-dark hover:bg-customBlue-light dark:hover:bg-customCyan-light dark:shadow-customCyan-700/75 shadow-customBlue-600/75 py-2 text-white"
                        >
                            <template x-if="!showPreview">
                                <span>
                                    <i class="fa-solid fa-eye mr-1"></i>
                                    {{ __('Preview') }}
                                </span>
                            </template>

                            <template x-if="showPreview">
                                <span>
                                    <i class="fa-solid fa-arrow-rotate-left mr-1"></i>
                                    {{ __('Back to Form') }}
                                </span>
                            </template>
                        </x-ui.buttons.loadable>

                        <template x-if="!showPreview">
                            <x-ui.buttons.loadable
                                alpine-model="loading"
                                type="submit"
                                class="dark:bg-customPurple dark:border-customPurple-dark bg-customGreen border-customGreen-dark hover:bg-customGreen-light dark:hover:bg-customPurple-light dark:shadow-customPurple-700/75 shadow-customGreen-600/75 py-2 text-white"
                            >
                                <i class="fa-solid fa-message mr-1"></i>
                                {{ __('Post Comment') }}
                            </x-ui.buttons.loadable>
                        </template>
                    </x-slot:actions>
                </x-ui.textarea>
            </div>
        </div>
    @endauth
    <div class="w-full h-auto" id="comments">
        <x-title-box
            title="{{ __('Article Comments') }}"
            description="{{ __('All comments of this article') }}"
            icon="users-comments"
        />
    </div>
    @include('pages.articles.fragments.article-comments')
</div>
@endif
