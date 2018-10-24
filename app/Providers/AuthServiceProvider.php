<?php

namespace App\Providers;

use App\Expense;
use App\ExpenseItem;
use App\Income;
use App\Policies\ExpenseItemPolicy;
use App\Policies\ExpensePolicy;
use App\Policies\IncomePolicy;
use App\Policies\SourceOfIncomePolicy;
use App\Policies\WalletPolicy;
use App\SourceOfIncome;
use App\Wallet;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        Wallet::class => WalletPolicy::class,
        SourceOfIncome::class => SourceOfIncomePolicy::class,
        Income::class => IncomePolicy::class,
        Expense::class => ExpensePolicy::class,
        ExpenseItem::class => ExpenseItemPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
