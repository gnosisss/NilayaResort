<?php

namespace App\Policies;

use App\Models\BankVerification;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class BankVerificationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        $isBankOfficer = $user->isBankOfficer();
        
        if (!$isBankOfficer) {
            Log::warning('Non-bank officer attempted to access BankVerification resource', [
                'user_id' => $user->id,
                'user_email' => $user->email
            ]);
        }
        
        return $isBankOfficer;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BankVerification $bankVerification): bool
    {
        return $user->isBankOfficer();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isBankOfficer();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BankVerification $bankVerification): bool
    {
        return $user->isBankOfficer();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BankVerification $bankVerification): bool
    {
        return $user->isBankOfficer();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BankVerification $bankVerification): bool
    {
        return $user->isBankOfficer();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BankVerification $bankVerification): bool
    {
        return $user->isBankOfficer();
    }
}