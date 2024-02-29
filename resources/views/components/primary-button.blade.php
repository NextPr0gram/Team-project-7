


<button {{ $attributes->merge(['type' => 'submit', 'class' => 'px-3 md:px-4 lg:px-6 h-8 md:h-9 lg:h-10 text-base text-neutral-30 bg-primary-300 rounded-sm hover:bg-primary-400 active:bg-primary-200 transition ease-in-out duration-150 ']) }}>
    {{ $slot }}
</button>

