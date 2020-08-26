<?php

namespace App\Architect\Plans\MemberBookings;

use Illuminate\Database\Eloquent\Model;
use JPeters\Architect\Plans\Plan as ArchitectPlan;

class Plan extends ArchitectPlan
{
    public function vuePrefix(): string
    {
        return 'member-bookings';
    }


    public function handleUpdate(Model $model, $column, $value)
    {
        //
    }

    public function getCurrentValue(Model $model)
    {
        return $model->bookings()->count();
    }

    public function hasDatabaseColumn(): bool
    {
        return false;
    }
}
