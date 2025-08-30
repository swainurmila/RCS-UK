<?php

namespace App\Policies;

use App\Models\SocietyAppDetail;
use App\Models\User;

class SocietyApplicationPolicy
{
    /**
     * Determine if the user can view the application.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SocietyAppDetail  $app
     * @return bool
     */
    public function view(User $user, SocietyAppDetail $app)
    {
        return true;
        if (in_array($user->getRoleNames()->first(), ['superadmin', 'admin', 'register', 'society'])) {
            return true;
        }
        return $app->current_role === $user->role ||
            $app->submitted_to_user_id === $user->id ||
            $app->flows()->where(function ($q) use ($user) {
                $q->where('from_role', $user->role)->orWhere('to_role', $user->role);
            })->exists();
    }

    /**
     * Determine if the user can take action on the application.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SocietyAppDetail  $app
     * @return bool
     */
    public function act(User $user, SocietyAppDetail $app)
    {
        $userRole = strtolower($user->getRoleNames()->first()); // normalize to lowercase
        $appRole = strtolower($app->current_role);

        if (in_array($app->status, [0, 2, 3, 5]) || $userRole  == "society") {
            return false; // If the application is in final approval, no one can take action
        }
        if ($app->status == 1 && $appRole === 'arcs') {
            return $userRole === 'arcs' &&
                ($app->submitted_to_user_id === null || $app->submitted_to_user_id === $user->id);
        }

        return $appRole === $userRole &&
            ($app->submitted_to_user_id === null || $app->submitted_to_user_id === $user->id);
    }
}
