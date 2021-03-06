<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
/* fbsg-signature-addPassportConfig:<begin> */
use Laravel\Passport\Passport;
/* fbsg-signature-addPassportConfig:<end> */

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        /* fbsg-signature-addPolicyRegistration:<begin> */
		'App\task' => 'App\Policies\taskPolicy',
        /* fbsg-signature-addPolicyRegistration:<end> */
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

          /* fbsg-signature-addPassportConfig:<begin> */
        Passport::routes();
        Passport::tokensExpireIn(now()->addDays(1));
        Passport::refreshTokensExpireIn(now()->addDays(2));
        /* fbsg-signature-addPassportConfig:<end> */

        //
    }
}
