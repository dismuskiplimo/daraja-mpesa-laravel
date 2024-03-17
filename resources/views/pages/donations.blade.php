<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Donations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-center text-xl font-bold mb-8">Donations</h2>
            <table class="table-auto border-solid border border-slate-600">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Telephone</th>
                        <th>Donation Type</th>
                        <th>Amount (KES)</th>
                        <th>Note</th>
                        <th>MPESA Receipt Number</th>
                        <th>Payment Made</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($donations as $donation)
                        <tr class="odd:bg-slate-200 even:bg-slate-100">
                            <td>{{ $donation->donor_name }}</td>
                            <td>{{ $donation->phone }}</td>
                            <td>{{ $donation->donation_type }}</td>
                            <td>{{ $donation->amount }}</td>
                            <td>{{ $donation->donor_note }}</td>
                            <td>{{ $donation->mpesa_receipt_number }}</td>
                            <td>{!! $donation->fulfilled == '1' ? '<span class = "text-green-600">YES</span>' : '<span class = "text-red-600">NO</span>' !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-guest-layout>