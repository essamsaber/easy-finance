<?php

namespace App\Policies;

use App\User;
use App\Income;
use Illuminate\Auth\Access\HandlesAuthorization;

class IncomePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the income.
     *
     * @param  \App\User  $user
     * @param  \App\Income  $income
     * @return mixed
     */
    public function view(User $user, Income $income)
    {
        return $user->id === $income->user_id;
    }

    /**
     * Determine whether the user can create incomes.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the income.
     *
     * @param  \App\User  $user
     * @param  \App\Income  $income
     * @return mixed
     */
    public function update(User $user, Income $income)
    {
        return $user->id === $income->user_id;
    }

    /**
     * Determine whether the user can delete the income.
     *
     * @param  \App\User  $user
     * @param  \App\Income  $income
     * @return mixed
     */
    public function delete(User $user, Income $income)
    {
        return $user->id === $income->user_id;
    }

    /**
     * Determine whether the user can restore the income.
     *
     * @param  \App\User  $user
     * @param  \App\Income  $income
     * @return mixed
     */
    public function restore(User $user, Income $income)
    {
        return $user->id === $income->user_id;
    }

    /**
     *
     * @param  \App\User  $user
     * @param  \App\Income  $income
     * @return mixed
     */
    public function edit(User $user, Income $income)
    {
        return $user->id === $income->user_id;
    }
}
