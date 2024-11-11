@extends('layouts.app')

@section('content')
    <div class="h-screen">
        <div class="container mx-auto p-6">
            
            <div class="mb-6">
            
            <div class="flex justify-between flex-wrap">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800 mb-6">All Payments</h1>
                </div>
                <div class="flex flex-wrap gap-2 pt-4">
                    <div>
                        <a href="{{ route('stripe.processPayment') }}" class="bg-gray-800 text-white px-6 py-2 rounded hover:bg-gray-900">Make Payment</a>
                    </div>
                    <div>
                        <a href="{{ route('payments.pdf') }}" class="bg-gray-800 text-white px-6 py-2 rounded-md hover:bg-gray-900">
                            Download PDF
                        </a>
                    </div>
                </div>
            </div>
            <div class="mt-8 md:mt-0 xl:mt-0 lg:mt-0">
                <form method="GET" action="{{ route('payments.index') }}" class="mb-6 flex justify-end space-x-4">
                    <input type="text" name="search" class="border px-4 py-2 rounded-md w-1/3" placeholder="Search by Name, Email, or Amount" value="{{ request('search') }}">
                    <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-900">Search</button>
                </form>
            </div>
            <!-- Display Success or Error Message -->
            @if(session('success'))
                <div class="bg-green-500 text-white p-4 rounded-md mb-6">
                    {{ session('success') }}
                </div>
            @elseif(session('error'))
                <div class="bg-red-500 text-white p-4 rounded-md mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Payment Table -->
            <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
                <table class="min-w-full table-auto text-sm">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">Name</th>
                            <th class="px-4 py-3 text-left font-semibold">Email</th>
                            <th class="px-4 py-3 text-left font-semibold">Amount (USD)</th>
                            <th class="px-4 py-3 text-left font-semibold">Payment ID</th>
                            <th class="px-4 py-3 text-left font-semibold">Status</th>
                            <th class="px-4 py-3 text-left font-semibold">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                            <tr class="hover:bg-gray-50">
                                <td class="border-b px-4 py-3">{{ $payment->cardholder_name }}</td>
                                <td class="border-b px-4 py-3">{{ $payment->email }}</td>
                                <td class="border-b px-4 py-3">${{ number_format($payment->amount, 2) }}</td>
                                <td class="border-b px-4 py-3">{{ $payment->stripe_payment_id }}</td>
                                <td class="border-b px-4 text-green-500 py-3">Paid</td>
                                <td class="border-b px-4 py-3">{{ $payment->created_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- No Payments Available Message -->
            @if($payments->isEmpty())
                <div class="bg-yellow-100 text-yellow-800 p-4 rounded-md mt-4">
                    No payments have been made yet.
                </div>
            @endif
        </div>

    </div>
    @endsection
