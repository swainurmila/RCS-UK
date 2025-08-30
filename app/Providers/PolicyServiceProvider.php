<?php

namespace App\Providers;

use App\Models\Complaint;
use App\Models\SocietyAppDetail;
use App\Policies\ComplaintApplicationPolicy;
use App\Models\AmendmentSociety;
use App\Policies\AmendmentApplicationPolicy;
use App\Policies\SocietyApplicationPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class PolicyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Register policies manually if needed
        Gate::policy(SocietyAppDetail::class, SocietyApplicationPolicy::class);
        Gate::policy(Complaint::class, ComplaintApplicationPolicy::class);
        Gate::policy(AmendmentSociety::class, AmendmentApplicationPolicy::class);
    }
}