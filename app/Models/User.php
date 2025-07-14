<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the rental units owned by the user.
     */
    public function rentalUnits(): HasMany
    {
        return $this->hasMany(RentalUnit::class, 'user_id', 'id');
    }

    /**
     * Get the bookings made by the user.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'user_id', 'id');
    }

    /**
     * Get the checkout transactions made by the user.
     */
    public function checkoutTransactions(): HasMany
    {
        return $this->hasMany(CheckoutTransaction::class, 'user_id', 'id');
    }
    
    /**
     * Get the property documents uploaded by the user.
     */
    public function propertyDocuments(): HasMany
    {
        return $this->hasMany(PropertyDocument::class, 'user_id', 'id');
    }
    
    /**
     * Get the property purchases made by the user.
     */
    public function propertyPurchases(): HasMany
    {
        return $this->hasMany(PropertyPurchase::class, 'user_id', 'id');
    }
    
    /**
     * Get the bank verifications performed by the user (if bank officer).
     */
    public function bankVerifications(): HasMany
    {
        return $this->hasMany(BankVerification::class, 'bank_user_id', 'id');
    }
    
    /**
     * Check if the user is a bank officer.
     * 
     * @return bool
     */
    public function isBankOfficer(): bool
    {
        return $this->role === 'bank_officer';
    }
    
    /**
     * Check if the user has any of the specified roles.
     * 
     * @param array $roles
     * @return bool
     */
    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role, $roles);
    }
    
    /**
     * Check if the user has a specific role.
     * 
     * @param string $role
     * @return bool
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }
}
