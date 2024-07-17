<button
    {{ $attributes->merge(['class' => "focus:outline-none disabled:!text-slate-300 disabled:cursor-not-allowed dark:disabled:!bg-customPurple dark:disabled:!border-customPurple-dark disabled:!bg-customGreen disabled:!border-customGreen-dark transition-colors p-2 px-4 text-sm relative gap-2 justify-center items-center font-semibold flex rounded border-b-4" ]) }}
>
    {{ $slot }}
</button>
