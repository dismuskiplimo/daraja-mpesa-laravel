<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Thank You') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="text-center max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1>Thank you for your donation</h1>
            <p class="mt-10">
                <a class = "p-3 border-2 border-slate-600 hover:border-slate-800 text-slate" href="{{ route("home") }}">Donate Again?</a></p>       
        </div>
    </div>
</x-guest-layout>