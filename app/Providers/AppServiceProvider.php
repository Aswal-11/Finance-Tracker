<?php

namespace App\Providers;

use App\Models\FinancialRecord;
use App\Models\Post;
use App\Models\Role;
use App\Policies\FinancialRecordPolicy;
use App\Policies\PostPolicy;
use App\Policies\RolePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(Post::class, PostPolicy::class);
        Gate::policy(FinancialRecord::class, FinancialRecordPolicy::class);
    }
}
