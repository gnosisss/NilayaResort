<?php

namespace App\Http\Controllers;

use App\Models\PropertyPurchase;
use App\Models\PropertyDocument;
use App\Models\RentalUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PropertyController extends Controller
{
    /**
     * Display a listing of properties for sale.
     */
    public function index()
    {
        $properties = RentalUnit::where('is_for_sale', true)->with(['category', 'images'])->get();
        
        return view('properties.index', compact('properties'));
    }

    /**
     * Display the specified property.
     */
    public function show($id)
    {
        $property = RentalUnit::where('is_for_sale', true)
            ->with(['category', 'images', 'facilities'])
            ->findOrFail($id);
        
        return view('properties.show', compact('property'));
    }

    /**
     * Show the form for creating a new property purchase.
     */
    public function createPurchase($id)
    {
        $property = RentalUnit::where('is_for_sale', true)->findOrFail($id);
        $documentTypes = PropertyDocument::$documentTypes;
        
        return view('properties.purchase', compact('property', 'documentTypes'));
    }

    /**
     * Store a newly created property purchase in storage.
     */
    public function storePurchase(Request $request, $id)
    {
        $property = RentalUnit::where('is_for_sale', true)->findOrFail($id);
        
        // Create property purchase
        $purchase = new PropertyPurchase([
            'user_id' => Auth::id(),
            'unit_id' => $property->unit_id,
            'purchase_code' => PropertyPurchase::generatePurchaseCode(),
            'purchase_amount' => $property->sale_price,
            'status' => 'pending',
            'notes' => $request->input('notes'),
        ]);
        
        $purchase->save();
        
        // Handle document uploads
        $documentTypes = array_keys(PropertyDocument::$documentTypes);
        
        foreach ($documentTypes as $type) {
            if ($request->hasFile($type)) {
                $file = $request->file($type);
                
                $validator = Validator::make(['file' => $file], [
                    'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
                ]);
                
                if ($validator->fails()) {
                    continue;
                }
                
                $fileName = $type . '_' . time() . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('property_documents', $fileName, 'public');
                
                $document = new PropertyDocument([
                    'user_id' => Auth::id(),
                    'purchase_id' => $purchase->purchase_id,
                    'document_type' => $type,
                    'file_path' => $filePath,
                    'file_name' => $fileName,
                    'file_extension' => $file->getClientOriginalExtension(),
                    'file_size' => $file->getSize(),
                    'status' => 'pending',
                ]);
                
                $document->save();
            }
        }
        
        return redirect()->route('properties.purchase.success', $purchase->purchase_id)
            ->with('success', 'Pengajuan pembelian properti berhasil dikirim!');
    }

    /**
     * Display the purchase success page.
     */
    public function purchaseSuccess($id)
    {
        $purchase = PropertyPurchase::with(['rentalUnit', 'documents'])->findOrFail($id);
        
        // Ensure the purchase belongs to the authenticated user
        if ($purchase->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('properties.success', compact('purchase'));
    }

    /**
     * Display the user's property purchases.
     */
    public function myPurchases()
    {
        $purchases = PropertyPurchase::with(['rentalUnit', 'documents', 'bankVerification'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('properties.my-purchases', compact('purchases'));
    }

    /**
     * Display the specified property purchase.
     */
    public function showPurchase($id)
    {
        $purchase = PropertyPurchase::with(['rentalUnit', 'documents', 'bankVerification'])
            ->findOrFail($id);
        
        // Ensure the purchase belongs to the authenticated user
        if ($purchase->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('properties.purchase-detail', compact('purchase')); // View for properties.purchase.show route
    }
}