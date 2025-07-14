<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\BankVerificationController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard Route
Route::get('/dashboard', [BookingController::class, 'index'])->name('dashboard');

// Authentication Routes
Auth::routes();

// Booking Routes
Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
Route::get('/bookings/create/{unit}', [BookingController::class, 'create'])->name('bookings.create');
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('bookings.my-bookings')->middleware('auth');
Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel')->middleware('auth');
Route::get('/bookings-calendar', [BookingController::class, 'calendar'])->name('bookings.calendar');

// Checkout Routes
Route::get('/bookings/{booking}/checkout', [CheckoutController::class, 'checkout'])->name('bookings.checkout')->middleware('auth');
Route::post('/bookings/{booking}/checkout', [CheckoutController::class, 'processCheckout'])->name('bookings.checkout.process')->middleware('auth');
Route::get('/checkout/success/{transaction}', [CheckoutController::class, 'checkoutSuccess'])->name('bookings.checkout.success')->middleware('auth');

// Transaction Routes
Route::get('/transactions/lookup', [TransactionController::class, 'lookup'])->name('transactions.lookup');
Route::post('/transactions/find', [TransactionController::class, 'find'])->name('transactions.find');
Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
Route::get('/transactions/{transaction}/print', [TransactionController::class, 'print'])->name('transactions.print');

// Payment Routes
Route::middleware('auth')->group(function () {
    Route::get('/payments/{transactionId}', [PaymentController::class, 'showPaymentForm'])->name('payments.form');
    Route::post('/payments/{transactionId}', [PaymentController::class, 'processPayment'])->name('payments.process');
    Route::get('/payments/{paymentId}/success', [PaymentController::class, 'showPaymentSuccess'])->name('payments.success');
    Route::get('/payments/history', [PaymentController::class, 'showPaymentHistory'])->name('payments.history');
    Route::get('/payments/{transactionId}/midtrans', [PaymentController::class, 'initiateMidtransPayment'])->name('payments.midtrans');
});

// Midtrans Routes
Route::prefix('midtrans')->group(function () {
    Route::post('/notification', [App\Http\Controllers\MidtransController::class, 'notification'])->name('midtrans.notification');
    Route::get('/finish', [App\Http\Controllers\MidtransController::class, 'finish'])->name('midtrans.finish');
    Route::get('/unfinish', [App\Http\Controllers\MidtransController::class, 'unfinish'])->name('midtrans.unfinish');
    Route::get('/error', [App\Http\Controllers\MidtransController::class, 'error'])->name('midtrans.error');
});

// Property Purchase Routes
Route::middleware('auth')->group(function () {
    Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
    Route::get('/properties/{unit}', [PropertyController::class, 'show'])->name('properties.show');
    Route::get('/properties/{unit}/purchase/create', [PropertyController::class, 'createPurchase'])->name('properties.purchase.create');
    Route::post('/properties/{unit}/purchase', [PropertyController::class, 'storePurchase'])->name('properties.purchase.store');
    Route::get('/properties/purchase/{purchase}/success', [PropertyController::class, 'purchaseSuccess'])->name('properties.purchase.success');
    Route::get('/my-purchases', [PropertyController::class, 'myPurchases'])->name('properties.my-purchases');
    Route::get('/my-purchases/{purchase}', [PropertyController::class, 'showPurchase'])->name('properties.purchase.show');
});

// Bank Verification Routes
Route::middleware(['auth', 'bank.officer'])->prefix('bank')->name('bank.')->group(function () {
    Route::get('/purchases', [BankVerificationController::class, 'index'])->name('index');
    Route::get('/purchases/{purchase}', [BankVerificationController::class, 'show'])->name('show');
    Route::post('/purchases/{purchase}/verify-documents', [BankVerificationController::class, 'verifyDocuments'])->name('verify-documents');
    Route::post('/purchases/{purchase}/approve-credit', [BankVerificationController::class, 'approveCredit'])->name('approve-credit');
    Route::post('/purchases/{purchase}/reject', [BankVerificationController::class, 'reject'])->name('reject');
});


