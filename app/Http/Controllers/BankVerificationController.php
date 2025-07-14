<?php

namespace App\Http\Controllers;

use App\Models\BankVerification;
use App\Models\PropertyPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankVerificationController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(BankVerification::class, 'verification');
    }
    
    /**
     * Display a listing of pending property purchases.
     */
    public function index()
    {
        $this->authorize('viewAny', BankVerification::class);
        
        $pendingPurchases = PropertyPurchase::with(['user', 'rentalUnit', 'documents'])
            ->whereIn('status', ['pending', 'verified'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('bank.index', compact('pendingPurchases'));
    }

    /**
     * Display the specified property purchase for verification.
     */
    public function show($id)
    {
        $purchase = PropertyPurchase::with(['user', 'rentalUnit', 'documents', 'bankVerification'])
            ->findOrFail($id);
        
        // Create bank verification record if it doesn't exist
        if (!$purchase->bankVerification) {
            $verification = new BankVerification([
                'purchase_id' => $purchase->purchase_id,
                'bank_user_id' => Auth::id(),
                'documents_verified' => false,
                'credit_approved' => false,
            ]);
            
            $this->authorize('create', $verification);
            $verification->save();
            
            // Reload the purchase with the new verification
            $purchase = PropertyPurchase::with(['user', 'rentalUnit', 'documents', 'bankVerification'])
                ->findOrFail($id);
        } else {
            $this->authorize('view', $purchase->bankVerification);
        }
        
        return view('bank.show', compact('purchase'));
    }

    /**
     * Verify documents for the specified property purchase.
     */
    public function verifyDocuments(Request $request, $id)
    {
        $purchase = PropertyPurchase::findOrFail($id);
        $verification = $purchase->bankVerification;
        
        if (!$verification) {
            $verification = new BankVerification([
                'purchase_id' => $purchase->purchase_id,
                'bank_user_id' => Auth::id(),
            ]);
            
            $this->authorize('create', $verification);
        } else {
            $this->authorize('update', $verification);
        }
        
        $verification->documents_verified = true;
        $verification->verification_notes = $request->input('verification_notes');
        $verification->save();
        
        // Update document statuses
        foreach ($purchase->documents as $document) {
            $document->status = 'verified';
            $document->save();
        }
        
        // Update purchase status if both documents and credit are verified
        if ($verification->isFullyVerified()) {
            $purchase->status = 'approved';
        } else {
            $purchase->status = 'verified';
        }
        
        $purchase->save();
        
        return redirect()->route('bank.show', $id)
            ->with('success', 'Dokumen berhasil diverifikasi!');
    }

    /**
     * Approve credit for the specified property purchase.
     */
    public function approveCredit(Request $request, $id)
    {
        $request->validate([
            'credit_score' => 'required|numeric|min:0|max:100',
            'approved_amount' => 'required|numeric|min:0',
        ]);
        
        $purchase = PropertyPurchase::findOrFail($id);
        $verification = $purchase->bankVerification;
        
        if (!$verification) {
            $verification = new BankVerification([
                'purchase_id' => $purchase->purchase_id,
                'bank_user_id' => Auth::id(),
            ]);
            
            $this->authorize('create', $verification);
        } else {
            $this->authorize('update', $verification);
        }
        
        $verification->credit_approved = true;
        $verification->credit_score = $request->input('credit_score');
        $verification->approved_amount = $request->input('approved_amount');
        $verification->verification_notes = $request->input('verification_notes');
        $verification->save();
        
        // Update purchase status if both documents and credit are verified
        if ($verification->isFullyVerified()) {
            $purchase->status = 'approved';
        } else {
            $purchase->status = 'verified';
        }
        
        $purchase->save();
        
        return redirect()->route('bank.show', $id)
            ->with('success', 'Kredit berhasil disetujui!');
    }

    /**
     * Reject the specified property purchase.
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);
        
        $purchase = PropertyPurchase::findOrFail($id);
        $verification = $purchase->bankVerification;
        
        if (!$verification) {
            $verification = new BankVerification([
                'purchase_id' => $purchase->purchase_id,
                'bank_user_id' => Auth::id(),
            ]);
            
            $this->authorize('create', $verification);
        } else {
            $this->authorize('update', $verification);
        }
        
        $verification->verification_notes = $request->input('rejection_reason');
        $verification->save();
        
        $purchase->status = 'rejected';
        $purchase->notes = $request->input('rejection_reason');
        $purchase->save();
        
        return redirect()->route('bank.index')
            ->with('success', 'Pengajuan pembelian properti berhasil ditolak!');
    }
}