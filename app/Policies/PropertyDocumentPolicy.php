<?php

namespace App\Policies;

use App\Models\PropertyDocument;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class PropertyDocumentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // All authenticated users can view the list of property documents
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PropertyDocument $propertyDocument): bool
    {
        // Users can view their own documents or bank officers can view any document
        return $user->id === $propertyDocument->user_id || $user->isBankOfficer();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Any authenticated user can create a property document
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PropertyDocument $propertyDocument): bool
    {
        // Bank officers can update any document (to mark as verified)
        if ($user->isBankOfficer()) {
            return true;
        }
        
        // Users can only update their own documents if they're not yet verified
        return $user->id === $propertyDocument->user_id && $propertyDocument->status !== 'verified';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PropertyDocument $propertyDocument): bool
    {
        // Bank officers can delete any document
        if ($user->isBankOfficer()) {
            return true;
        }
        
        // Users can only delete their own documents if they're not yet verified
        return $user->id === $propertyDocument->user_id && $propertyDocument->status !== 'verified';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PropertyDocument $propertyDocument): bool
    {
        // Only bank officers can restore deleted documents
        return $user->isBankOfficer();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PropertyDocument $propertyDocument): bool
    {
        // Only bank officers can permanently delete documents
        return $user->isBankOfficer();
    }
}