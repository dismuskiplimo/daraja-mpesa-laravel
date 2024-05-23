<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Make Donation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-center">
            <h1>Thank you for your donation</h1>
            <p style = "margin-top: 30px"><a class = "p-3 bg-gray-800 text-white" href = "{{ route("home") }}">Make another Donation</a></p>
        </div>
    </div>
</x-guest-layout>