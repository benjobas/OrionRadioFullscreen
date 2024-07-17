@props([
    'isShopComponent' => false
])

<div class="flex justify-start min-h-[50px] h-auto bg-customGreen-dark dark:bg-customBlack-dark dark:border-slate-800 shadow">
    <x-container class="grid lg:grid-cols-4 lg:divide-x divide-slate-200 dark:divide-customBlack-light select-none">
        <div class="flex p-1 items-center justify-center hover:bg-customGreen-light dark:hover:bg-customBlack-light">
            <div class="w-6 h-full bg-center bg-no-repeat" style="background-image: url('{{ CurrencyType::Credits->getImage() }}')"></div>
            <span class="px-2 dark:text-white text-white text-sm">{{ __(':a credits', ['a' => Auth::user()->currency(CurrencyType::Credits)]) }}</span>
        </div>
        <div class="flex p-1 items-center justify-center hover:bg-customGreen-light dark:hover:bg-customBlack-light">
            <div class="w-6 h-full bg-center bg-no-repeat" style="background-image: url('{{ CurrencyType::Duckets->getImage() }}')"></div>
            <span class="px-2 dark:text-white text-white text-sm">{{ __(':a duckets', ['a' => Auth::user()->currency(CurrencyType::Duckets)]) }}</span>
        </div>
        <div class="flex p-1 items-center justify-center hover:bg-customGreen-light dark:hover:bg-customBlack-light">
            <div class="w-6 h-full bg-center bg-no-repeat" style="background-image: url('{{ CurrencyType::Diamonds->getImage() }}')"></div>
            <span class="px-2 dark:text-white text-white text-sm">{{ __(':a diamonds', ['a' => Auth::user()->currency(CurrencyType::Diamonds)]) }}</span>
        </div>
        <div class="flex p-1 items-center justify-center hover:bg-customGreen-light dark:hover:bg-customBlack-light">
            <div class="w-6 h-full bg-center bg-no-repeat" style="background-image: url('{{ CurrencyType::Points->getImage() }}')"></div>
            <span class="px-2 dark:text-white text-white text-sm">{{ __(':a points', ['a' => Auth::user()->currency(CurrencyType::Points)]) }}</span>
        </div>
    </x-container>
</div>
