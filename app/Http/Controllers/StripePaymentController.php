<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Customer;
use Exception;

class StripePaymentController extends Controller
{
    public function showPaymentForm()
    {
        return view('payment-form');
    }
    

    public function processPayment(Request $request)
    {
        // Server-side validation
        $validatedData = $request->validate([
            'cardholder-name' => 'required|string|max:255',
            'email' => 'required|email',
            'amount' => 'required|numeric|min:1',
            'stripeToken' => 'required|string',
        ]);

        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            // Create a customer
            $customer = Customer::create([
                'name' => $validatedData['cardholder-name'],
                'email' => $validatedData['email'],
                'source' => $validatedData['stripeToken'],
            ]);

            // Charge the customer
            $charge = Charge::create([
                'customer' => $customer->id,
                'amount' => $validatedData['amount'] * 100, // Stripe requires amount in cents
                'currency' => 'usd',
                'description' => 'Payment from ' . $validatedData['cardholder-name'],
            ]);

            // Save payment details to the database
            Payment::create([
                'cardholder_name' => $validatedData['cardholder-name'],
                'email' => $validatedData['email'],
                'amount' => $validatedData['amount'],
                'stripe_payment_id' => $charge->id,
            ]);

            return back()->with('success', 'Payment Successful!');
        } catch (Exception $e) {
            return back()->with('error', 'Error processing payment: ' . $e->getMessage());
        }
    }

    // New function to fetch all payments
    public function getAllPayments(Request $request)
    {
        // Get search term from query parameters (if any)
        $search = $request->input('search');
    
        // Fetch payments based on search term
        $payments = Payment::when($search, function ($query, $search) {
            return $query->where('cardholder_name', 'like', "%$search%")
                         ->orWhere('email', 'like', "%$search%")
                         ->orWhere('amount', 'like', "%$search%");
        })->get();
    
        // Return a view with the payments data
        return view('payments.index', compact('payments'));
    }
    
    public function generatePdf()
    {
        $payments = Payment::all(); // Fetch all payments

        // Check if there are any payments
        if ($payments->isEmpty()) {
            return back()->with('error', 'No payments to generate PDF.');
        }

        // Load the payments view with payments data
        $pdf = PDF::loadView('payments.pdf', compact('payments'));

        // Download the PDF file with a custom name
        return $pdf->download('payments_list.pdf');
    }
}
