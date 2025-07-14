<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\RentalUnit;
use App\Models\Availability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Display a listing of available rental units.
     */
    public function index(Request $request)
    {
        $query = RentalUnit::with(['category', 'images', 'facilities']);
        
        // Apply filters if provided
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        
        if ($request->has('price_min') && $request->has('price_max')) {
            $query->whereBetween('price_per_night', [$request->price_min, $request->price_max]);
        }
        
        $rentalUnits = $query->paginate(9);
        
        return view('bookings.index', compact('rentalUnits'));
    }

    /**
     * Show the form for creating a new booking.
     */
    public function create(Request $request, $unitId)
    {
        $rentalUnit = RentalUnit::with(['category', 'images', 'facilities'])->findOrFail($unitId);
        
        // Get available dates for the next 3 months
        $startDate = Carbon::now();
        $endDate = Carbon::now()->addMonths(3);
        
        // Get availability ranges
        $availabilityRanges = Availability::where('unit_id', $unitId)
            ->where('is_available', true)
            ->where('start_date', '>=', $startDate)
            ->where('end_date', '<=', $endDate->addDays(30))
            ->get(['start_date', 'end_date']);
            
        // Generate all available dates from the ranges
        $availableDates = [];
        foreach ($availabilityRanges as $range) {
            $rangeStart = Carbon::parse($range->start_date);
            $rangeEnd = Carbon::parse($range->end_date);
            
            // Generate all dates in the range
            for ($date = clone $rangeStart; $date->lte($rangeEnd); $date->addDay()) {
                $availableDates[] = $date->format('Y-m-d');
            }
        }
        
        // Remove duplicates
        $availableDates = array_unique($availableDates);
        
        return view('bookings.create', compact('rentalUnit', 'availableDates'));
    }

    /**
     * Store a newly created booking in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'unit_id' => 'required|exists:rental_units,unit_id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);
        
        // Check if the dates are available
        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);
        
        $dateRange = [];
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $dateRange[] = $date->format('Y-m-d');
        }
        
        // Check availability for all dates in the range
        $availabilityCheck = true;
        
        // Get all availability ranges that overlap with the requested date range
        $availabilityRanges = Availability::where('unit_id', $validated['unit_id'])
            ->where('is_available', true)
            ->where(function($query) use ($startDate, $endDate) {
                // Find ranges that contain the requested dates
                $query->where(function($q) use ($startDate, $endDate) {
                    $q->where('start_date', '<=', $startDate)
                      ->where('end_date', '>=', $endDate);
                })
                // Or find ranges that overlap with the requested dates
                ->orWhere(function($q) use ($startDate, $endDate) {
                    $q->where('start_date', '>=', $startDate)
                      ->where('start_date', '<=', $endDate);
                })
                ->orWhere(function($q) use ($startDate, $endDate) {
                    $q->where('end_date', '>=', $startDate)
                      ->where('end_date', '<=', $endDate);
                });
            })
            ->get();
            
        // Check if all dates in the range are covered by available ranges
        $coveredDates = [];
        foreach ($availabilityRanges as $range) {
            $rangeStart = max(Carbon::parse($range->start_date), $startDate);
            $rangeEnd = min(Carbon::parse($range->end_date), $endDate);
            
            for ($date = clone $rangeStart; $date->lte($rangeEnd); $date->addDay()) {
                $coveredDates[] = $date->format('Y-m-d');
            }
        }
        
        // Check if all requested dates are covered
        $coveredDates = array_unique($coveredDates);
        $availabilityCheck = count($coveredDates) === count($dateRange);
        
        if ($availabilityCheck) {
            return back()->withErrors(['dates' => 'Some of the selected dates are not available.']);
        }
        
        // Create the booking
        $booking = new Booking();
        $booking->user_id = Auth::id();
        $booking->unit_id = $validated['unit_id'];
        $booking->start_date = $validated['start_date'];
        $booking->end_date = $validated['end_date'];
        $booking->status = 'pending';
        $booking->save();
        
        // Update availability by splitting or marking existing ranges
        $availabilityRanges = Availability::where('unit_id', $validated['unit_id'])
            ->where('is_available', true)
            ->where(function($query) use ($startDate, $endDate) {
                // Find ranges that overlap with the requested dates
                $query->where(function($q) use ($startDate, $endDate) {
                    $q->where('start_date', '<=', $endDate)
                      ->where('end_date', '>=', $startDate);
                });
            })
            ->get();
            
        foreach ($availabilityRanges as $range) {
            $rangeStart = Carbon::parse($range->start_date);
            $rangeEnd = Carbon::parse($range->end_date);
            
            // Case 1: Booking completely covers the availability range
            if ($startDate->lte($rangeStart) && $endDate->gte($rangeEnd)) {
                $range->is_available = false;
                $range->save();
            }
            // Case 2: Booking is in the middle of the range - split into two ranges
            else if ($startDate->gt($rangeStart) && $endDate->lt($rangeEnd)) {
                // Create first part (before booking)
                Availability::create([
                    'unit_id' => $range->unit_id,
                    'start_date' => $rangeStart,
                    'end_date' => $startDate->copy()->subDay(),
                    'is_available' => true,
                    'status' => $range->status,
                    'price' => $range->price,
                    'notes' => $range->notes
                ]);
                
                // Create second part (after booking)
                Availability::create([
                    'unit_id' => $range->unit_id,
                    'start_date' => $endDate->copy()->addDay(),
                    'end_date' => $rangeEnd,
                    'is_available' => true,
                    'status' => $range->status,
                    'price' => $range->price,
                    'notes' => $range->notes
                ]);
                
                // Mark the original range as unavailable
                $range->is_available = false;
                $range->save();
            }
            // Case 3: Booking covers the start of the range
            else if ($startDate->lte($rangeStart) && $endDate->lt($rangeEnd)) {
                // Update the start date of the existing range
                $range->start_date = $endDate->copy()->addDay();
                $range->save();
            }
            // Case 4: Booking covers the end of the range
            else if ($startDate->gt($rangeStart) && $endDate->gte($rangeEnd)) {
                // Update the end date of the existing range
                $range->end_date = $startDate->copy()->subDay();
                $range->save();
            }
        }
        
        // Create a new unavailable range for the booking
        Availability::create([
            'unit_id' => $validated['unit_id'],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_available' => false,
            'status' => 'booked',
            'price' => null,
            'notes' => 'Booked by booking #' . $booking->booking_id
        ]);
        
        return redirect()->route('bookings.show', $booking->booking_id)
            ->with('success', 'Booking created successfully!');
    }

    /**
     * Display the specified booking.
     */
    public function show($id)
    {
        $booking = Booking::with(['rentalUnit', 'rentalUnit.category', 'rentalUnit.images', 'checkoutTransaction'])
            ->findOrFail($id);
        
        // Ensure the user can only see their own bookings
        if (Auth::id() !== $booking->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('bookings.show', compact('booking'));
    }

    /**
     * Show the user's bookings.
     */
    public function myBookings()
    {
        $bookings = Booking::with(['rentalUnit'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('bookings.my-bookings', compact('bookings'));
    }

    /**
     * Cancel the specified booking.
     */
    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);
        
        // Ensure the user can only cancel their own bookings
        if (Auth::id() !== $booking->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        // Only pending or confirmed bookings can be cancelled
        if (!in_array($booking->status, ['pending', 'confirmed'])) {
            return back()->withErrors(['status' => 'This booking cannot be cancelled.']);
        }
        
        // Update booking status
        $booking->status = 'cancelled';
        $booking->save();
        
        // Make the dates available again
        $startDate = Carbon::parse($booking->start_date);
        $endDate = Carbon::parse($booking->end_date);
        
        // Find the unavailable range created for this booking
        $bookedRange = Availability::where('unit_id', $booking->unit_id)
            ->where('start_date', $startDate)
            ->where('end_date', $endDate)
            ->where('is_available', false)
            ->where('status', 'booked')
            ->first();
            
        if ($bookedRange) {
            // Create a new available range
            Availability::create([
                'unit_id' => $booking->unit_id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'is_available' => true,
                'status' => 'available',
                'price' => null,
                'notes' => 'Released from cancelled booking #' . $booking->booking_id
            ]);
            
            // Delete the unavailable range
            $bookedRange->delete();
        }
        
        return redirect()->route('bookings.my-bookings')
            ->with('success', 'Booking cancelled successfully!');
    }


    /**
     * Display the booking calendar showing all booked dates.
     */
    public function calendar(Request $request)
    {
        // Get all rental units for the dropdown
        $rentalUnits = RentalUnit::all();
        
        // Initialize query for bookings
        $bookingsQuery = Booking::with(['rentalUnit', 'user'])
            ->where('status', '!=', 'cancelled');
            
        // Initialize query for availabilities
        $availabilitiesQuery = Availability::with(['rentalUnit'])
            ->where('is_available', true);
        
        // Filter by unit if specified
        if ($request->has('unit_id') && $request->unit_id) {
            $bookingsQuery->where('unit_id', $request->unit_id);
            $availabilitiesQuery->where('unit_id', $request->unit_id);
        }
        
        // Filter by month if specified
        if ($request->has('month')) {
            $month = $request->month;
            $startOfMonth = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
            $endOfMonth = Carbon::createFromFormat('Y-m', $month)->endOfMonth();
            
            $bookingsQuery->where(function($query) use ($startOfMonth, $endOfMonth) {
                $query->whereBetween('start_date', [$startOfMonth, $endOfMonth])
                    ->orWhereBetween('end_date', [$startOfMonth, $endOfMonth])
                    ->orWhere(function($q) use ($startOfMonth, $endOfMonth) {
                        $q->where('start_date', '<', $startOfMonth)
                          ->where('end_date', '>', $endOfMonth);
                    });
            });
            
            $availabilitiesQuery->where(function($query) use ($startOfMonth, $endOfMonth) {
                $query->whereBetween('start_date', [$startOfMonth, $endOfMonth])
                    ->orWhereBetween('end_date', [$startOfMonth, $endOfMonth])
                    ->orWhere(function($q) use ($startOfMonth, $endOfMonth) {
                        $q->where('start_date', '<', $startOfMonth)
                          ->where('end_date', '>', $endOfMonth);
                    });
            });
        } else {
            // Default to current month
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();
            
            $bookingsQuery->where(function($query) use ($startOfMonth, $endOfMonth) {
                $query->whereBetween('start_date', [$startOfMonth, $endOfMonth])
                    ->orWhereBetween('end_date', [$startOfMonth, $endOfMonth])
                    ->orWhere(function($q) use ($startOfMonth, $endOfMonth) {
                        $q->where('start_date', '<', $startOfMonth)
                          ->where('end_date', '>', $endOfMonth);
                    });
            });
            
            $availabilitiesQuery->where(function($query) use ($startOfMonth, $endOfMonth) {
                $query->whereBetween('start_date', [$startOfMonth, $endOfMonth])
                    ->orWhereBetween('end_date', [$startOfMonth, $endOfMonth])
                    ->orWhere(function($q) use ($startOfMonth, $endOfMonth) {
                        $q->where('start_date', '<', $startOfMonth)
                          ->where('end_date', '>', $endOfMonth);
                    });
            });
        }
        
        $bookings = $bookingsQuery->get();
        $availabilities = $availabilitiesQuery->get();
        
        return view('bookings.calendar', compact('rentalUnits', 'bookings', 'availabilities'));
    }

}