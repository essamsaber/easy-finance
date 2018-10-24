<?php

namespace App\Policies;

use App\User;
use App\SourceOfIncome;
use Illuminate\Auth\Access\HandlesAuthorization;

class SourceOfIncomePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the source of income.
     *
     * @param  \App\User  $user
     * @param  \App\SourceOfIncome  $sourceOfIncome
     * @return mixed
     */
    public function view(User $user, SourceOfIncome $sourceOfIncome)
    {
        return $user->id === $sourceOfIncome->user_id;
    }

    /**
     * Determine whether the user can create source of incomes.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the source of income.
     *
     * @param  \App\User  $user
     * @param  \App\SourceOfIncome  $sourceOfIncome
     * @return mixed
     */
    public function update(User $user, SourceOfIncome $sourceOfIncome)
    {
        return $user->id === $sourceOfIncome->user_id;
    }

    /**
     * Determine whether the user can delete the source of income.
     *
     * @param  \App\User  $user
     * @param  \App\SourceOfIncome  $sourceOfIncome
     * @return mixed
     */
    public function delete(User $user, SourceOfIncome $sourceOfIncome)
    {
        return $user->id === $sourceOfIncome->user_id;
    }

    /**
     * Determine whether the user can restore the source of income.
     *
     * @param  \App\User  $user
     * @param  \App\SourceOfIncome  $sourceOfIncome
     * @return mixed
     */
    public function restore(User $user, SourceOfIncome $sourceOfIncome)
    {
        return $user->id === $sourceOfIncome->user_id;
    }

    /**
     *
     * @param  \App\User  $user
     * @param  \App\SourceOfIncome  $sourceOfIncome
     * @return mixed
     */
    public function edit(User $user, SourceOfIncome $sourceOfIncome)
    {
        return $user->id === $sourceOfIncome->user_id;
    }
}
