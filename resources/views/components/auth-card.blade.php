<!-- resources/views/components/authentication-card.blade.php -->
<div class="bg-white shadow-md sm:rounded-lg p-6">
    @isset($logo)
        <div class="mb-4 flex justify-center">
            {{ $logo }}
        </div>
    @endisset

    <!-- This is where any child content passed via the <x-authentication-card> ... </x-authentication-card> will go -->
    {{ $slot }}
</div>
