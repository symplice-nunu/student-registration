@extends('layouts.app')

@section('content')
    <div class="h-screen pt-8">
        <div class="w-full max-w-md mx-auto bg-white shadow-md rounded-lg p-8">
            <h2 class="text-2xl font-bold text-center mb-6">Stripe Payment</h2>

            @if ($errors->any())
                <div class="mb-4 p-4 text-red-600 bg-red-100 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(session('success'))
                <div class="bg-green-500 text-center text-white p-4 rounded-md mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form id="payment-form" action="{{ route('stripe.processPayment') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="cardholder-name">Cardholder Name</label>
                    <input type="text" name="cardholder-name" id="cardholder-name" value="{{ old('cardholder-name') }}" 
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('cardholder-name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" 
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="amount">Amount (USD)</label>
                    <input type="number" name="amount" id="amount" value="{{ old('amount') }}" min="1" 
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('amount')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Card Number</label>
                    <div id="card-number-element" class="p-2 border rounded-lg"></div>
                </div>

                <div class="flex gap-4 mb-4">
                    <div class="flex-1">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Expiry Date</label>
                        <div id="card-expiry-element" class="p-2 border rounded-lg"></div>
                    </div>
                    <div class="flex-1">
                        <label class="block text-gray-700 text-sm font-bold mb-2">CVC</label>
                        <div id="card-cvc-element" class="p-2 border rounded-lg"></div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-500 text-white font-bold py-2 rounded-lg hover:bg-blue-600 focus:outline-none">
                    Pay Now
                </button>

                <input type="hidden" name="stripeToken" id="stripeToken">
            </form>
        </div>

        <script>
            const stripe = Stripe('{{ config('services.stripe.key') }}');
            const elements = stripe.elements();

            const style = {
                base: {
                    color: "#32325d",
                    fontSize: "16px",
                    '::placeholder': {
                        color: '#a0aec0',
                    },
                },
                invalid: {
                    color: "#fa755a",
                },
            };

            const cardNumberElement = elements.create('cardNumber', { style });
            const cardExpiryElement = elements.create('cardExpiry', { style });
            const cardCvcElement = elements.create('cardCvc', { style });

            cardNumberElement.mount('#card-number-element');
            cardExpiryElement.mount('#card-expiry-element');
            cardCvcElement.mount('#card-cvc-element');

            const form = document.getElementById('payment-form');
            form.addEventListener('submit', async (e) => {
                e.preventDefault();

                const {token, error} = await stripe.createToken(cardNumberElement);

                if (error) {
                    alert(error.message);
                } else {
                    document.getElementById('stripeToken').value = token.id;
                    form.submit();
                }
            });
        </script>

    </div>

@endsection
