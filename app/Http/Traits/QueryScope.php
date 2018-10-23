<?php
/**
 * Created by PhpStorm.
 * User: esam
 * Date: 10/23/2018
 * Time: 4:31 PM
 */

namespace App\Http\Traits;


trait QueryScope
{
    public function scopeMine($query)
    {
        $query->where('user_id', auth()->id());
    }
}