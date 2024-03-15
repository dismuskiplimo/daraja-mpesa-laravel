$<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Donations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2>Donations</h2>
            <table>
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
                        <tr>
                            <td>{{ $donation->donor_name }}</td>
                            <td>{{ $donation->phone }}</td>
                            <td>{{ $donation->donation_type }}</td>
                            <td>{{ $donation->amount }}</td>
                            <td>{{ $donation->donor_note }}</td>
                            <td>{{ $donation->mpesa_receipt_number }}</td>
                            <td>{!! $donation->fulfilled == '1' ? 'YES' : 'NO' !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-guest-layout>