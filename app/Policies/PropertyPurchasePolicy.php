<?php

namespace App\Policies;

use App\Models\PropertyPurchase;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class PropertyPurchasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // All authenticated users can view the list of property purchases
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PropertyPurchase $propertyPurchase): bool
    {
        // Users can view their own purchases or bank officers can view any purchase
        return $user->id === $propertyPurchase->user_id || $user->isBankOfficer();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Any authenticated user can create a property purchase
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PropertyPurchase $propertyPurchase): bool
    {
        // Only bank officers can update property purchases
        // Or the owner if the status is still 'pending'
        if ($user->isBankOfficer()) {
            return true;
        }
        
        return $user->id === $propertyPurchase->user_id && $propertyPurchase->status === 'pending';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PropertyPurchase $propertyPurchase): bool
    {
        // Only the owner can delete their purchase if it's still pending
        if ($user->id === $propertyPurchase->user_id && $propertyPurchase->status === 'pending') {
            return true;
        }
        
        // Bank officers can delete any purchase
        return $user->isBankOfficer();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PropertyPurchase $propertyPurchase): bool
    {
        // Only bank officers can restore deleted purchases
        return $user->isBankOfficer();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PropertyPurchase $propertyPurchase): bool
    {
        // Only bank officers can permanently delete purchases
        return $user->isBankOfficer();
    }
}