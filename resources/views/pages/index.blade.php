<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Make Donation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <form action="" method = "POST">
                        @csrf
                        <div class = "form-group">
                            <label for="phone">Phone number (07XXXXXXXX e.g. 0720123456)</label>
                            <input type="text" name = "phone" id = "phone" placeholder="07XXXXXXXX" pattern="0[0-9]{9}" title = "Phone Number" required>
                        </div>
                
                        <div class = "form-group">
                            <label for="amount">Amount to Donate(Min: KES 5)</label>
                            <input type="number" name = "amount" min = "5" id = "amount" placeholder="amount" title = "Amount" required>
                        </div>
                
                        <button type="submit">Make Donation</button>
                    </form>
        </div>
    </div>
</x-guest-layout>