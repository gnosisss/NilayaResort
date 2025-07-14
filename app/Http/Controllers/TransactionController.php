<?php

namespace App\Http\Controllers;

use App\Models\CheckoutTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Show the form to lookup a transaction by code.
     */
    public function lookup()
    {
        return view('transactions.lookup');
    }

    /**
     * Find and display a transaction by its code.
     */
    public function find(Request $request)
    {
        $validated = $request->validate([
            'transaction_code' => 'required|string'
        ]);

        $transaction = CheckoutTransaction::with(['booking', 'booking.rentalUnit', 'transactionDetails'])
            ->where('transaction_code', $validated['transaction_code'])
            ->first();

        if (!$transaction) {
            return redirect()->route('transactions.lookup')
                ->withErrors(['transaction_code' => 'Transaction not found with the provided code.']);
        }

        // Check if the authenticated user owns this transaction
        if (Auth::check() && Auth::id() !== $transaction->user_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('transactions.show', compact('transaction'));
    }

    /**
     * Print a transaction receipt.
     */
    public function print($transactionId)
    {
        $transaction = CheckoutTransaction::with(['booking', 'booking.rentalUnit', 'transactionDetails'])
            ->findOrFail($transactionId);

        // Check if the authenticated user owns this transaction
        if (Auth::check() && Auth::id() !== $transaction->user_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('transactions.print', compact('transaction'));
    }
    
    /**
     * Show transaction details by transaction code.
     */
    public function show($transactionCode)
    {
        $transaction = CheckoutTransaction::with(['booking', 'booking.rentalUnit', 'booking.user', 'transactionDetails'])
            ->where('transaction_code', $transactionCode)
            ->firstOrFail();

        // Check if the authenticated user owns this transaction
        if (Auth::check() && Auth::id() !== $transaction->user_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('transactions.show', compact('transaction'));
    }
}