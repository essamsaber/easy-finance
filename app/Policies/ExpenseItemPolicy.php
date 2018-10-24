<?php

namespace App\Policies;

use App\User;
use App\ExpenseItem;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExpenseItemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the expense item.
     *
     * @param  \App\User  $user
     * @param  \App\ExpenseItem  $expenseItem
     * @return mixed
     */
    public function view(User $user, ExpenseItem $expenseItem)
    {
        return $user->id === $expenseItem->user_id;
    }

    /**
     * Determine whether the user can create expense items.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the expense item.
     *
     * @param  \App\User  $user
     * @param  \App\ExpenseItem  $expenseItem
     * @return mixed
     */
    public function update(User $user, ExpenseItem $expenseItem)
    {
        return $user->id === $expenseItem->user_id;
    }

    /**
     * Determine whether the user can delete the expense item.
     *
     * @param  \App\User  $user
     * @param  \App\ExpenseItem  $expenseItem
     * @return mixed
     */
    public function delete(User $user, ExpenseItem $expenseItem)
    {
        return $user->id === $expenseItem->user_id;
    }

    /**
     * Determine whether the user can restore the expense item.
     *
     * @param  \App\User  $user
     * @param  \App\ExpenseItem  $expenseItem
     * @return mixed
     */
    public function restore(User $user, ExpenseItem $expenseItem)
    {
        return $user->id === $expenseItem->user_id;
    }

    /**
     *
     * @param  \App\User  $user
     * @param  \App\ExpenseItem  $expenseItem
     * @return mixed
     */
    public function edit(User $user, ExpenseItem $expenseItem)
    {
        return $user->id === $expenseItem->user_id;
    }
}
