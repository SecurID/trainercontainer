<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-bg-primary border border-border-default rounded-md font-semibold text-xs text-text-primary uppercase tracking-widest shadow-sm hover:text-text-secondary focus:outline-none focus:border-primary-300 focus:shadow-outline-primary active:text-text-primary active:bg-bg-secondary transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
