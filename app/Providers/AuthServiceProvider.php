<?php

namespace App\Providers;

use App\Models\BankVerification;
use App\Models\PropertyDocument;
use App\Models\PropertyPurchase;
use App\Policies\BankVerificationPolicy;
use App\Policies\PropertyDocumentPolicy;
use App\Policies\PropertyPurchasePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        BankVerification::class => BankVerificationPolicy::class,
        PropertyPurchase::class => PropertyPurchasePolicy::class,
        PropertyDocument::class => PropertyDocumentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Define a bank officer gate
        Gate::define('bank-officer', function ($user) {
            return $user->isBankOfficer();
        });
    }
}