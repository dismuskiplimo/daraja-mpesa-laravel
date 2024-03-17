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

                <div class = "form-group flex flex-col mb-8">
                    <label for="donor-name" >Donor Name<span class = "text-red-600">*</span></label>
                    <input type="text" name = "donor_name" id = "donor-name" placeholder="John Doe" title = "Donor Name" value = "{{ old("donor_name") }}" required>
                </div>

                <div class = "form-group form-group flex flex-col mb-8">
                    <label for="phone">Telephone (07XXXXXXXX e.g. 0720123456)<span class = "text-red-600">*</span></label>
                    <input type="text" name = "phone" id = "phone" placeholder="07XXXXXXXX" pattern="0[0-9]{9}" title = "Phone Number" value = "{{ old("phone") }}" required>
                </div>

                <div class = "form-group form-group flex flex-col mb-8">
                    <label for="donation-type">Donation Type<span class = "text-red-600">*</span></label>
                    <select  name = "donation_type" id = "donation-type" title = "Donation Type" required>
                        <option {{ old('donation_type') != null && old('donation_type') == 'Tithe' ? 'selected' : "" }}>Tithe</option>
                        <option {{ old('donation_type') != null && old('donation_type') == 'Offertory' ? 'selected' : "" }}>Offertory</option>
                        <option {{ old('donation_type') != null && old('donation_type') == 'Church Development' ? 'selected' : "" }}>Church Development</option>
                        <option {{ old('donation_type') != null && old('donation_type') == 'Buy Pew' ? 'selected' : "" }}>Buy Pew</option>
                    </select>
                </div>
        
                <div class = "form-group form-group flex flex-col mb-8">
                    <label for="amount">Amount (Min: KES 5)<span class = "text-red-600">*</span></label>
                    <input type="number" name = "amount" min = "5" id = "amount" placeholder="500" title = "Amount" value = "{{ old("amount") }}" required>
                </div>

                <div class = "form-group form-group flex flex-col mb-8">
                    <label for="donor-note">Donor Note<span class = "text-red-600">*</span></label>
                    <textarea  name = "donor_note" id = "donor-note" title = "Donor Note" placeholder="Note" required>{{ old("donor_note") }}</textarea>
                </div>
        
                <button class="p-3 bg-gray-800 text-white" type="submit">Make Donation</button>
            </form>
        </div>
    </div>
</x-guest-layout>