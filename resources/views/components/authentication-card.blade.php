<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-bg-secondary">
    <div class="flex flex-col items-center">
        {{ $logo }}
        
        <!-- Language Switcher for Guest Pages -->
        <div class="mt-4">
            <livewire:language-switcher />
        </div>
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-bg-primary shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
