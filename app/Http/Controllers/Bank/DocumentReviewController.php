<?php

namespace App\Http\Controllers\Bank;

use App\Http\Controllers\Controller;
use App\Models\BankVerification;
use App\Models\PropertyPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentReviewController extends Controller
{
    /**
     * Display the document review for a specific bank verification.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bankVerification = BankVerification::with(['documentReviews', 'propertyPurchase'])
            ->findOrFail($id);
            
        // Check if user is authorized to view this verification
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'bank' && Auth::user()->id !== $bankVerification->propertyPurchase->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('bank.document-review', compact('bankVerification'));
    }
    
    /**
     * Display the document review for a specific property purchase.
     *
     * @param  int  $purchaseId
     * @return \Illuminate\Http\Response
     */
    public function showByPurchase($purchaseId)
    {
        $purchase = PropertyPurchase::findOrFail($purchaseId);
        
        // Check if user is authorized to view this purchase
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'bank' && Auth::user()->id !== $purchase->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        $bankVerification = BankVerification::with(['documentReviews', 'propertyPurchase'])
            ->where('purchase_id', $purchaseId)
            ->latest()
            ->first();
            
        if (!$bankVerification) {
            return redirect()->back()->with('error', 'No bank verification found for this purchase.');
        }
        
        return view('bank.document-review', compact('bankVerification'));
    }
}